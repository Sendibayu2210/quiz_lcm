<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content">
    <div class="container mt-3">
        <div class="border p-3 br-10">        
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
                <a href="/quiz" class="btn bg-primary mt-3 px-5">Start Quiz</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>