<?php if ($pager->haveToPaginate()): ?>
    <p>Results: <?php echo $pager->getNbResults(); ?></p>
    <ul class="pagination">
        <?php foreach ($pager->getLinks() as $page): ?>
            <li <?php $page == $pager->getPage() and print 'class="active"'; ?>>
                <a href="<?php echo url_for($route . "?page=" . $page); ?>">
                    <?php echo $page; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
