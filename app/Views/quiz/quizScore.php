<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content">
    <div class="container mt-3" id="history-quiz">

        <div class="h5 mb-5">History & Score</div>

        <div class="row">
            <div class="col-lg-8 small"> 
                <div class="alert alert-light mb-2" v-for="i in 10">
                    <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat minima ut atque dolorum nisi porro et itaque blanditiis architecto suscipit?</div>
                    <ul>
                        <li v-for="i in 4">test</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 mx-auto">
                <div class="card mx-auto br-15 border-primary border-0">
                    <div class="card-body mb-5">
                        <div class="mx-auto border text-center border-primary p-2 br-10 bg-white shadow text-primary" style="width: 130px; margin-top: -35px;">
                            Score
                        </div>
                        <div class="my-4 text-center mt-5">
                            <div class="p-2 bg-primary btn px-4 text-center fw-bold fs-5"><?= $data['score']; ?></div>
                        </div>
    
                        <div class="mt-4 text-center">
                            <div class="mb-2">
                                <div class="badge bg-info-light px-5 p-2"><i class="fas fa-check me-2"></i>Right Answer <?= $data['totalCorrect']; ?></div>
                            </div>
                            <div>
                                <div class="badge bg-danger-light px-5 p-2"><i class="fas fa-times me-2"></i>Wrong Answer <?= $data['totalWrong']; ?></div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    const {createApp}=Vue;
    createApp({
        data(){
            return{

            }
        }
    }).mount('#history-quiz')
</script>
<?= $this->endSection(); ?>