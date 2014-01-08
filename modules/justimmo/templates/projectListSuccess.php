<?php /** @var $project Justimmo\Model\Project */ ?>

<section>
    <h1>Project List</h1>
    <?php foreach ($projects as $project): ?>
        <div>
            <a href="<?php echo url_for("@justimmo_project_detail?id=" . $project->getId()); ?>">
                <h2>
                    <?php echo $project->getTitle(); ?>
                </h2>

                <?php echo $project->getDescription(ESC_RAW); ?>
            </a>
        </div>
    <?php endforeach; ?>
</section>
