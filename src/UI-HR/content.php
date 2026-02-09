<div id="view-panel" class="container-fluid table-responsive" style="height: 90vh; overflow-y: auto !important;">
    <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
    <?php include $page . '.php' ?>
</div>