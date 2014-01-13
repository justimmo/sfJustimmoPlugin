<table class="realties-table">
    <thead>
    <tr>
        <th><?php echo __('Objekt-Nr.'); ?></th>
        <th><?php echo __('Zimmer'); ?></th>
        <th class="text-right"><?php echo __('Wohnfläche'); ?></th>
        <th class="text-right"><?php echo __('Gesamtfläche'); ?></th>
        <th class="text-right"><?php echo __('Mietpreis'); ?></th>
        <th class="text-right"><?php echo __('Kaufpreis'); ?></th>
        <th>&nbsp;</th>
    </tr>
    </thead>

    <tbody>
    <?php /** @var \Justimmo\Model\Realty $realty */ ?>
    <?php foreach ($realties as $realty): ?>
        <tr>
            <td><?php echo $realty->getPropertyNumber(); ?></td>
            <td><?php echo $realty->getRoomCount(); ?></td>
            <td class="text-right">
                <?php if ($realty->getLivingArea() > 0): ?>
                    <?php echo number_format($realty->getLivingArea(), 2, ',', '.') . ' m²'; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td class="text-right">
                <?php if ($realty->getTotalArea()): ?>
                    <?php echo number_format($realty->getTotalArea(), 2, ',', '.') . ' m²'; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td class="text-right">
                <?php if ($realty->getTotalRent() > 0): ?>
                    <?php echo number_format($realty->getTotalRent(), 2, ',', '.'); ?>&nbsp;&euro;
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td class="text-right">
                <?php if ($realty->getPurchasePrice() > 0): ?>
                    <?php echo number_format($realty->getPurchasePrice(), 2, ',', '.'); ?>&nbsp;&euro;
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td class="text-right">
                <?php if ($realty->getStatus() != ''): ?>
                    <span class="btn-realty-status"><?php echo __($realty->getStatus()); ?></span>
                <?php else: ?>
                    <?php echo link_to(__('Anzeigen &raquo;'), '@justimmo_realty_detail?id=' . $realty->getId(), array('class' => 'btn-view-realty')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
