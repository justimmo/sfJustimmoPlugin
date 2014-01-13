<?php /** @var $project Justimmo\Model\Project */ ?>

<section>
    <h1>Project List</h1>
    <?php foreach ($pager as $project): ?>
        <div>
            <a href="<?php echo url_for("@justimmo_project_detail?id=" . $project->getId()); ?>">
                <h2>
                    <?php echo $project->getTitle(); ?>
                </h2>

                <?php echo $project->getTeaser(); ?>
            </a>
        </div>
    <?php endforeach; ?>

    <?php include_partial('pagination', array('pager' => $pager, 'route' => '@justimmo_project_list')); ?>

</section>
