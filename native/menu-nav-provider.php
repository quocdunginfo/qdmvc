<?php
if (!class_exists('qd_Custom_Nav')) {
    class qd_Custom_Nav
    {
        public function add_nav_menu_meta_boxes()
        {
            add_meta_box(
                'wl_login_nav_link',
                __('Product Cat'),
                array($this, 'nav_menu_link'),
                'nav-menus',
                'side',
                'low'
            );
        }

        public function nav_menu_link()
        {
            ?>
            <div id="posttype-wl-login" class="posttypediv">
                <div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
                    <ul id="wishlist-login-checklist" class="categorychecklist form-no-clear">
                        <li>


                            <?php
                            $count = 1;
                            foreach (QdProductCat::all() as $item): ?>
                                <label class="menu-item-title">
                                    <input type="checkbox" class="menu-item-checkbox"
                                           name="menu-item[-<?= $count ?>][menu-item-object-id]" value="-<?= $count ?>">
                                    <?=$item->name?>
                                </label>
                                <input type="hidden" class="menu-item-type"
                                       name="menu-item[-<?= $count ?>][menu-item-type]" value="custom">
                                <input type="hidden" class="menu-item-title"
                                       name="menu-item[-<?= $count ?>][menu-item-title]" value="<?=$item->name?>">
                                <input type="hidden" class="menu-item-url"
                                       name="menu-item[-<?= $count ?>][menu-item-url]"
                                       value="<?= $item->getPermalink() ?>">
                                <input type="hidden" class="menu-item-classes"
                                       name="menu-item[-<?= $count ?>][menu-item-classes]" value="wl-login-pop">
                                <br/>
                                <?php
                                $count++;
                            endforeach; ?>
                        </li>
                    </ul>
                </div>
                <p class="button-controls">
        			<span class="add-to-menu">
        				<input type="submit" class="button-secondary submit-add-to-menu right" value="Add to Menu"
                               name="add-post-type-menu-item" id="submit-posttype-wl-login">
        				<span class="spinner"></span>
        			</span>
                </p>
            </div>
        <?php
        }
    }
}
$custom_nav = new qd_Custom_Nav();
add_action('admin_init', array($custom_nav, 'add_nav_menu_meta_boxes'));