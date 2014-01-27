<?php /** @var \Justimmo\Model\Realty $realty */ ?>

<div class="justimmo realty-details">
<h3><?php echo __('Eckdaten'); ?></h3>

<table>
<tr>
    <th><?php echo __('Objektnummer'); ?></th>
    <th><?php echo $realty->getPropertyNumber(); ?></th>
</tr>

<?php if ($realty->getRealtyType()): ?>
    <tr>
        <td><?php echo __('Objektart'); ?>:</td>
        <td><?php echo $realty->getRealtyType(); ?></td>
    </tr>
<?php endif; ?>

<?php if ($realty->getCountry()): ?>
    <tr>
        <td><?php echo __('Land'); ?>:</td>
        <td><?php echo $realty->getCountry(); ?></td>
    </tr>
<?php endif; ?>

<tr>
    <th colspan="2"><?php echo __('Preisinformation'); ?></th>
</tr>

<?php if ($realty->getPurchasePrice() > 0): ?>
    <tr>
        <td><?php echo __('Kaufpreis'); ?>:</td>
        <td><?php echo number_format($realty->getPurchasePrice(), 2, ',', '.'); ?> &euro;</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getNetRent() > 0): ?>
    <tr>
        <td><?php echo __('Nettomiete'); ?>:</td>
        <td><?php echo number_format($realty->getNetRent(), 2, ',', '.'); ?> &euro;</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getOperatingCostsNet() > 0): ?>
    <tr>
        <td><?php echo __('Nettobetriebskosten'); ?>:</td>
        <td>
            <?php echo number_format($realty->getOperatingCostsNet(), 2, ',', '.'); ?> &euro;

            <?php if ($realty->getOperatingCostsVat() > 0): ?>
                (exkl. <?php echo number_format($realty->getOperatingCostsVat(), 0, ',', '.'); ?>% USt.)
            <?php else: ?>
                <?php echo __('(exkl. USt.)'); ?>
            <?php endif; ?>
        </td>
    </tr>
<?php endif; ?>

<?php if ($realty->getHeatingCostsGross() > 0): ?>
    <tr>
        <td><?php echo __('Heizkosten'); ?>:</td>
        <td>
            <?php echo number_format($realty->getHeatingCostsGross(), 2, ',', '.'); ?> &euro;

            <?php if ($realty->getHeatingCostsVat() > 0): ?>
                (inkl. <?php echo number_format($realty->getHeatingCostsVat(), 0, ',', '.'); ?>% USt.)
            <?php else: ?>
                <?php echo __('(inkl. USt.)'); ?>
            <?php endif; ?>
        </td>
    </tr>
<?php endif; ?>

<?php /** @var \Justimmo\Model\AdditionalCosts $cost */ ?>
<?php foreach ($realty->getAdditionalCosts() as $index => $cost): ?>
    <?php if (false): ?>
        <tr>
            <td>
                <?php echo $cost->getName(); ?>:
            </td>
            <td>
                <?php echo number_format($cost->getGross(), 2, ',', '.'); ?> &euro;
                <?php if ($cost->getVat() > 0): ?>
                    (inkl. <?php echo number_format($cost->getVat(), 0, ',', '.'); ?>% USt.)
                <?php else: ?>
                    <?php echo __('(inkl. USt.)'); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
<?php endforeach; ?>

<?php if ($realty->getTotalRentVat() > 0): ?>
    <tr>
        <td><?php echo __('Umsatzsteuer'); ?>:</td>
        <td><?php echo number_format($realty->getTotalRentVat(), 2, ',', '.'); ?> &euro;</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getTotalRent() > 0): ?>
    <tr>
        <td><?php echo __('Gesamtmiete'); ?>:</td>
        <td><?php echo number_format($realty->getTotalRent(), 2, ',', '.'); ?> &euro;</td>
    </tr>
<?php endif; ?>

<?php
// todo: find out what warmmiete is
if (false && $realty->preise->warmmiete && (string)$realty->preise->warmmiete > 0): ?>
    <tr>
        <td><?php echo __('Gesamtmiete'); ?>:</td>
        <td><?php echo __('ca.'); ?> <?php echo number_format((string)$realty->preise->warmmiete, 2, ',', '.'); ?> €</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getYield() > 0): ?>
    <tr>
        <td><?php echo __('Rendite'); ?>:</td>
        <td><?php echo number_format($realty->getYield(), 1, ',', '.'); ?> %</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getNetEarningMonthly() > 0): ?>
    <tr>
        <td><?php echo __('Nettoertrag (monatlich)'); ?>:</td>
        <td><?php echo number_format($realty->getNetEarningMonthly(), 2, ',', '.'); ?> &euro;</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getNetEarningYearly() > 0): ?>
    <tr>
        <td><?php echo __('Nettoertrag (jährlich)'); ?>:</td>
        <td><?php echo number_format($realty->getNetEarningYearly(), 2, ',', '.'); ?> &euro;</td>
    </tr>
<?php endif; ?>
<!-- Eckdaten -->

<tr>
    <th colspan="2">Details</th>
</tr>

<?php if ($realty->getSurfaceArea() > 0): ?>
    <tr>
        <td><?php echo __('Grundfläche'); ?>:</td>
        <td><?php echo number_format($realty->getSurfaceArea(), 2, ',', '.'); ?> m²</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getLivingArea() > 0): ?>
    <tr>
        <td><?php echo __('Wohnfläche'); ?>:</td>
        <td><?php echo number_format($realty->getLivingArea(), 2, ',', '.'); ?> m²</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getFloorArea() > 0): ?>
    <tr>
        <td><?php echo __('Nutzfläche'); ?>:</td>
        <td><?php echo number_format($realty->getFloorArea(), 2, ',', '.'); ?> m²</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getRoomCount() > 0): ?>
    <tr>
        <td><?php echo __('Zimmer'); ?>:</td>
        <td><?php echo $realty->getRoomCount(); ?></td>
    </tr>
<?php endif; ?>

<?php if ($realty->getBathroomCount() > 0): ?>
    <tr>
        <td><?php echo __('Bäder'); ?>:</td>
        <td><?php echo $realty->getBathroomCount(); ?></td>
    </tr>
<?php endif; ?>

<?php if ($realty->getToiletRoomCount() > 0): ?>
    <tr>
        <td><?php echo __('WC'); ?>:</td>
        <td><?php echo $realty->getToiletRoomCount(); ?></td>
    </tr>
<?php endif; ?>

<?php if ($realty->getTerraceCount() > 0): ?>
    <tr>
        <td><?php echo __('Terrassen'); ?>:</td>
        <td><?php echo $realty->getTerraceCount(); ?></td>
    </tr>
<?php endif; ?>

<?php if ($realty->getBalconyTerraceCount()): ?>
    <tr>
        <td><?php echo __('Balkone'); ?>:</td>
        <td>
            <?php echo $realty->getBalconyTerraceCount(); ?>
            <?php if ($realty->getBalconyTerraceArea() > 0): ?>
                , <?php echo number_format($realty->getBalconyTerraceArea(), 2, ',', '.'); ?>m²
            <?php endif; ?>
        </td>
    </tr>
<?php endif; ?>

<?php if ($realty->getCellarArea() > 0): ?>
    <tr>
        <td><?php echo __('Keller'); ?>:</td>
        <td><?php echo number_format($realty->getCellarArea(), 2, ',', '.') ?> m²</td>
    </tr>
<?php endif; ?>

<?php
// todo: where / what is stellplatzart and or ausstattung?
if (false && $realty->ausstattung->stellplatzart && $realty->ausstattung->stellplatzart['GARAGE']): ?>
    <tr>
        <td><?php echo __('Garage'); ?>:</td>
        <td><?php echo __('vorhanden'); ?></td>
    </tr>
<?php endif; ?>

<?php if (false && $realty->ausstattung->moebliert && $realty->ausstattung->moebliert['moeb']): ?>
    <tr>
        <td><?php echo __('möbliert'); ?>:</td>
        <td>ja</td>
    </tr>
<?php endif; ?>

<?php if ($realty->getEnergyPass()): ?>

    <?php if ($realty->getEnergyPass()->getThermalHeatRequirementValue() > 0): ?>
        <tr>
            <td><?php echo __('Heizwärmebedarf'); ?>:</td>
            <td>
                <?php // @todo: see about the colors
                /*
                <span style="color: #ffffff; background-color:<?php echo $bedarf->getFarbcode(); ?>">&nbsp;<?php echo $bedarf->getKlasse(); ?>&nbsp;</span>
                */
                ?>
                <span><?php echo $realty->getEnergyPass()->getThermalHeatRequirementClass() ?></span>
                <?php echo $realty->getEnergyPass()->getThermalHeatRequirementValue(); ?> kWh / m² * a
            </td>
        </tr>
    <?php endif; ?>

    <?php if ($realty->getEnergyPass()->getEnergyEfficiencyFactorValue() > 0): ?>
        <tr>
            <td><?php echo __('Gesamtenergie-effizienzfaktor'); ?>:</td>
            <td>
                <?php // @todo: see about colors
                /*
                    <span style="color: #ffffff; background-color:<?php echo $faktor->getFarbcode(); ?>">&nbsp;<?php echo $faktor->getKlasse(); ?>&nbsp;</span>
                */
                ?>
                <span><?php echo $realty->getEnergyPass()->getEnergyEfficiencyFactorClass(); ?></span>
                <?php echo $realty->getEnergyPass()->getEnergyEfficiencyFactorValue(); ?>
            </td>
        </tr>
    <?php endif; ?>

    <?php if ($realty->getEnergyPass()->getValidUntil()): ?>
        <tr>
            <td><?php echo __('Energieausweis gültig bis'); ?>:</td>
            <td><?php echo $realty->getEnergyPass()->getValidUntil()->format('d/m/Y'); ?></td>
        </tr>
    <?php endif; ?>

<?php endif; ?>

<?php
/*
<?php if ($realty->ausstattung->heizungsart): ?>
   <tr>
       <td><?php echo __('Heizung'); ?>:</td>
       <td>
           <?php if ($realty->ausstattung->heizungsart['FUSSBODEN']): ?>
               <?php echo __('Fußbodenheizung'); ?>
           <?php elseif ($realty->ausstattung->heizungsart['ETAGE']): ?>
               <?php echo __('Etagenheizung'); ?>
           <?php elseif ($realty->ausstattung->heizungsart['FERN']): ?>
               <?php echo __('Fernheizung'); ?>
           <?php endif; ?>
       </td>
   </tr>
<?php endif; ?>
*/
?>

<?php if (count($realty->getEquipment()) > 0): ?>
    <tr>
        <th colspan="2"><?php echo __('Ausstattung'); ?></th>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $realty->getEquipmentDescription(); ?>
        </td>
    </tr>
<?php endif; ?>
</table>
</div>


<?php

// @todo: the stuff below was in another version ... double check and make sure all info is correct on this WHOLE page!
/*
 *
 <?php $zusatzkosten = $realty->preise->zusatzkosten; ?>

    <?php if ($zusatzkosten->betriebskosten && (string)$zusatzkosten->betriebskosten->brutto > 0): ?>
        <tr>
            <td><?php echo __('Betriebskosten'); ?>:</td>
            <td>
                <?php echo number_format((string)$zusatzkosten->betriebskosten->brutto, 2, ',', '.'); ?> €

                <?php if ((string)$zusatzkosten->betriebskosten->ust > 0): ?>
                    <?php echo __('(inkl. %1% % USt.)', array('%1%' => number_format((string)$zusatzkosten->betriebskosten->ust, 0, ',', '.'))); ?>
                <?php else: ?>
                    <?php echo __('(inkl. USt.)'); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>

    <?php if ($zusatzkosten->heizkosten && (string)$zusatzkosten->heizkosten->brutto > 0): ?>
        <tr>
            <td><?php echo __('Heizkosten'); ?>:</td>
            <td>
                <?php echo number_format((string)$zusatzkosten->heizkosten->brutto, 2, ',', '.'); ?> €

                <?php if ((string)$zusatzkosten->heizkosten->ust > 0): ?>
                    <?php echo __('(inkl. %1% % USt.)', array('%1%' => number_format((string)$zusatzkosten->heizkosten->ust, 0, ',', '.'))); ?>
                <?php else: ?>
                    <?php echo __('(inkl. USt.)'); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>

    <?php foreach ((array)$zusatzkosten as $index => $tmp): ?>
        <?php if (strstr($index, 'zusatzkosten_') && (string)$tmp->brutto > 0): ?>
            <tr>
                <td><?php echo (string)$tmp->name; ?>:</td>
                <td>
                    <?php echo number_format((string)$tmp->brutto, 2, ',', '.'); ?> €

                    <?php if ((string)$tmp->ust > 0): ?>
                        <?php echo __('(inkl. %1% % USt.)', array('%1%' => number_format((string)$tmp->ust, 0, ',', '.'))); ?>
                    <?php else: ?>
                        <?php echo __('(inkl. USt.)'); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>







<?php foreach ($realty->user_defined_simplefield as $field) : ?>
    <?php if ($field->attributes()->feldname == 'raumsicht360_link') : ?>
        <a href="<?php echo $field ?>" class="fancybox-virtual-tour"><?php echo image_tag('raumsicht.png', array('alt_title' => 'Virtuelle Tour starten')) ?></a>

    <?php endif; ?>
<?php endforeach; ?>

<?php if ($realty->verwaltung_techn->projekt_id && strlen($realty->verwaltung_techn->projekt_id) > 0): ?>
    <?php include_component('projekt', 'sidebarDetail', array('id' => $realty->verwaltung_techn->projekt_id)) ?>
<?php endif; ?>
?>
*/
?>
