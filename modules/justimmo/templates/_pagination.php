<?php if ($pager->haveToPaginate()): ?>
    <p>Results: <?php echo $pager->getNbResults(); ?></p>
    <ul class="pagination">
        <?php foreach ($pager->getLinks() as $page): ?>
            <li <?php $page == $pager->getPage() and print 'class="active"'; ?>>
                <a href="<?php echo url_for($route . "?page=" . $page); $sf_user->getAttribute('filter_order', null, 'justimmo') !== null and print '?order='.$sf_user->getAttribute('filter_order', null, 'justimmo'); ?>">
                    <?php echo $page; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
