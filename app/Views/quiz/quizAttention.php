<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content">
    <?= view('components/navbar'); ?>
    <div class="container mt-3">
        <div class="border p-3 br-10 bg-warning-light border-primary border-2"> 

            <div class="">
                <?php if($status=='not yet' || $status=='progress') : ?>
                    <div class="h5 mb-3">Attention</div>
                    <ol type="1">
                        <li>No Assistance: Participants are prohibited from assisting or giving hints to other participants during the quiz.</li>
                        <li>No Copying of Answers: Participants are not allowed to copy answers from other participants or other sources during the quiz.</li>
                        <li>Adherence to Time: Participants must complete the quiz within the specified time. No extension will be given except in the case of system errors.</li>
                        <li>Correct Answers: Answers considered correct are those that match the answer key set by the quiz organizers.</li>
                        <li>Organizer's Decision: The decision of the quiz organizers is final and cannot be contested.</li>
                        <li>Mandatory Attendance: Participants must be present and start the quiz on time. Latecomers may be disqualified.</li>
                        <li>Confidentiality: Quiz answers and participants' personal information will be kept confidential by the organizers.</li>
                        <li>Disclosure: Participants are prohibited from disclosing quiz answers or information to other participants before, during, or after the quiz.</li>
                        <li>Etiquette: Participants are expected to maintain etiquette in interacting with the organizers and other participants.</li>
                    </ol>
                    <p>By starting the quiz, participants are deemed to have agreed to all the above rules. Good luck with the quiz and may you succeed!</p>

                    <div class="text-start">
                        <a href="/quiz?periode=<?= $periode[0]['id_periode']; ?>" class="btn bg-primary mt-3 px-5"><?= ($status=='not yet') ? 'Start' : 'Continue'; ?> Quiz</a>
                    </div>
                <?php endif; ?>

                <?php if($status == '-') : ?>
                    <div class="my-5 text-center text-danger fw-bold">
                        <div class="fs-5 mb-3"><i class="fas fa-warning"></i></div>
                        Sorry, you are not able to take the quiz yet!!
                    </div>
                <?php endif; ?>

                <?php if($status == 'finish') : ?>
                    <div class="my-5 text-center text-primary fw-bold">
                        <div>You have finished this quiz</div>
                        <a href="/quiz/score" class="btn btn-primary mt-4 px-4">View History & Score</a>
                    </div>
                <?php endif; ?>

                <?php if($status == 'questions is null') : ?>
                    <div class="my-5 text-center text-danger fw-bold">
                        <div><i class="fas fa-warning h5"></i></div>
                        <div>Sorry, Questions is null. please contact admin</div>                        
                    </div>
                <?php endif; ?>
            </div>
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