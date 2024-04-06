<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<div class="row mh-100vh" id="quiz">
    <div class="col-lg-9 bg-warning">

        <div class="container mt-5">

            <div class="mb-4">
                <span class="bg-info h1 fw-bold text-white px-4">Quiz</span>
            </div>

            <div class="card border border-3 border-primary">
                <div class="card-body">
                    <div class="text-primary">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores quia magnam, dolor totam, nulla laborum minima sit ratione et laudantium maxime aperiam ipsam velit atque facilis. Molestias voluptate modi voluptatibus.</div>
                    <div class="mt-4 "> 
                        <div class="bg-primary p-2 mb-2 d-flex" v-for="i in 5">
                            <button class="btn bg-warning text-danger fw-bold btn-sm me-2">A</button>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae nostrum sit nam? Pariatur, repellat et.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button class="btn bg-primary text-white me-2 px-3 border border-light border-3 fw-bold">Previous</button>
                <button class="btn bg-primary text-white px-4 border border-light border-3 fw-bold">Next</button>
            </div>

        </div>


    </div>
    <div class="col-lg-3 bg-primary">

        <div class="mt-5">
            <div class="mx-5 bg-danger h1 fw-bold text-center border border-light border-3 py-1">00:00</div>
        </div>
        <div class="mt-3 mb-3 text-center">
        <div class="badge bg-light border border-info border-2 text-info p-2 m-1 fs-5" v-for="number in 50" :class="(number==1) ? 'bg-info text-white' : '' ">
                {{ (number<=9) ? '0'+number : number }}
            </div>
        </div>

        <div class="my-3 text-center">
            <button class="btn bg-warning px-5 fw-bold text-primary border border-light border-3">Finish</button>
        </div>
    </div>
</div>

<script>
    const {createApp} = Vue
    createApp({
        data(){
            return{

            }
        }
    }).mount('#quiz')
</script>

<?= $this->endSection(); ?>