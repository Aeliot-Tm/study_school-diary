<?php
//THINK
//namespace views\Core\menu;

/**
 * @param array $items
 * @param int $level
 */
function renderMenu(array $items, int $level = 0)
{ ?>
    <li class="menu level-<?php echo $level; ?>">
        <?php foreach ($items as $item) { ?>
            <ol class="menu-item">
                <?php if ($item['url']) { ?>
                    <a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a>
                <?php } else { ?>
                    <span href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></span>
                <?php } ?>
                <?php
                $children = $item['children'] ?? null;
                if ($children) {
                    renderMenu($children, $level + 1);
                }
                ?>
            </ol>
        <?php } ?>
    </li>
<?php }

/** @var \Template\MenuItem[] $menu */
renderMenu($menu);