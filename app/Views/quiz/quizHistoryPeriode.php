<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content">
    <?= view('components/navbar'); ?>
    <div class="container mt-3">
        <div class="border p-3 br-10 bg-warning-light border-primary border-2"> 
            
            <?php if(is_array($periode)) : ?>
                <div class="table-responsive">
                    <table class="w-100" id="data-table">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Periode</th>
                                <th class="text-start">Start Date</th>
                                <th>Status</th>
                                <th class="text-start">Score</th>
                                <th class="text-start">Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($periode as $key => $dt) : ?>
                                <tr class="border-0 border-bottom border-1 border-secondary">
                                    <td class="p-2 text-center"><?= $key+1; ?></td>
                                    <td><?= $dt['periode']; ?></td>
                                    <td class="text-start"><?= $dt['start_time']; ?></td>                                    
                                    <td><?= $dt['status_progress']; ?></td> 
                                    <td class="text-start"><?= $dt['score']; ?></td>                                    
                                    <td class="text-start"><?= $dt['level']; ?></td>                                    
                                    <td>
                                        <?php if($dt['status_progress']=='not yet') { ?>
                                            <a href="/quiz/attention/<?= $dt['id']; ?>" class="btn btn-sm btn-primary px-3">Start Quiz</a>
                                        <?php }else if($dt['status_progress']=='progress'){ ?>
                                            <a href="/quiz/attention/<?= $dt['id']; ?>" class="btn btn-sm btn-warning px-3">Continue Quiz</a>
                                        <?php }else{ ?>
                                            <a href="/quiz/score/<?= $dt['id']; ?>" class="btn btn-sm btn-warning px-3">Preview</a>
                                        <?php } ?>
                                    </td>
                                </tr>    
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
            <?php endif; ?>            
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        new DataTable('#data-table')
    })
</script>
<?= $this->endSection(); ?>