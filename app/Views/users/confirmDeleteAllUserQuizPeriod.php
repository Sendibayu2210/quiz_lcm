<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content">
    <div class="container mt-4">
        
        <div class="card mt-3 bg-warning-light border-primary border-3 br-10">
            <div class="card-body">
                <div class="h5">Confirmation</div>

                <div class="fw-bold mb-3">Please choose your action for periode : <?= $periode['periode']; ?></div>

                <div>You have students who have already completed the quiz. <br>Please choose whether to delete all data or only students who have not completed the quiz.</div>
                <form action="/admin/students-periode-delete" class="mt-4" method="post" id="form-turn-off">
                    <input type="hidden" name="id-periode" value="<?= $idPeriode; ?>">
                    <input type="hidden" name='category' id="category">
                    <button type="button" class="btn btn-primary px-4 me-2" onClick="actionDelete('all')">Turn off all student</button>
                    <button type="button" class="btn btn-primary px-4 me-2" onClick="actionDelete('havent-quizzed')">Turn off students who haven't quizzed</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>    
    function actionDelete(category)
    {
        $('#category').val(category)    
        $('#form-turn-off').submit();
    }
</script>

<?= $this->endSection(); ?>