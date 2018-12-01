<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 11:19
 */

namespace Core\Form;

use Core\HTTP\Session;
use Core\HTTP\SessionProvider;
use Core\Security\StringBuilder;

class CSRFHelper
{
    const KEY_FORMS = '__csrf_forms';
    const KEY_SECRET = '__csrf_secret';

    /**
     * @var Session
     */
    private $session;

    /**
     * @var StringBuilder
     */
    private $stringBuilder;

    /**
     * @param SessionProvider $sessionProvider
     * @param StringBuilder $stringBuilder
     * @throws \Exception
     */
    public function __construct(SessionProvider $sessionProvider, StringBuilder $stringBuilder)
    {
        $this->session = $sessionProvider();
        $this->stringBuilder = $stringBuilder;
    }

    /**
     * @param string $form
     * @return string
     */
    public function getFormKey(string $form): string
    {
        $formKeys = $this->session->get(self::KEY_FORMS, []);
        if (!array_key_exists($form, $formKeys)) {
            $max = $formKeys ? max(array_column($formKeys, 'index')) : 0;
            $index = ++$max;
            $formKeys[$form] = ['index' => $index, 'key' => str_pad($index, 3, 'x', STR_PAD_LEFT)];
            $this->session->set(self::KEY_FORMS, $formKeys);
        }

        return $formKeys[$form]['key'];
    }

    /**
     * @param string $key
     * @return string
     */
    public function getToken(string $key): string
    {
        $hash = $this->getHash($key, $this->getSCRFSecret());

        return implode(':', [$key, $hash]);
    }

    /**
     * @param string $token
     * @param string $formKey
     * @return bool
     */
    public function isValid(string $token, string $formKey): bool
    {
        list($key, $hash) = explode(':', $token);
        if ($formKey !== $key) {
            return false;
        }
        $secret = $this->getSCRFSecret();

        return $this->getHash($key, $secret) === $hash;
    }

    /**
     * @param string $key
     * @param string $secret
     * @return string
     */
    private function getHash(string $key, string $secret): string
    {
        return md5(sprintf('%s:%s', $key, $secret));
    }

    /**
     * @return string
     */
    private function getSCRFSecret(): string
    {
        if (!$this->session->has(self::KEY_SECRET)) {
            $secret = $this->stringBuilder->buildString(15);
            $this->session->set(self::KEY_SECRET, $secret);
        }

        return $this->session->get(self::KEY_SECRET);
    }
}
