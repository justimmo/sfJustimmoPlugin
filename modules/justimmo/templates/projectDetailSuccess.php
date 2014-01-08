<?php /** @var $project Justimmo\Model\Project */ ?>

<h1>Project</h1>

<h2><?php echo $project->getTitle(); ?></h2>

<?php echo $project->getDescription(ESC_RAW); ?>


<p>
    <a href="<?php echo url_for("@justimmo_project_list"); ?>">Projects List</a>
</p>
