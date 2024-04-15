const menuSidebar = [
    '<div class="mb-4 ps-3"><a href="profile.html" class="text-white">Profile</a></div>',
    '<div class="mb-4 ps-3"><a href="quiz.html" class="text-white">Quiz</a></div>',
    '<div class="mb-4 ps-3"><a href="history.html" class="text-white">History</a></div>',
    '<div class="mb-4 ps-3"><a href="about.html" class="text-white">About</a></div>',
    '<div class="mb-4 ps-3" id="btn-logout"><span class="text-white">Logout</span></div>',

    '<div class="mb-4 ps-3 mt-5"></div>',
    '<div class="mb-4 ps-3"><a href="quiz_upload.html" class="text-white">Quiz Upload</a></div>',
    '<div class="mb-4 ps-3"><a href="student_score.html" class="text-white">Student Score</a></div>',
];

$(document).ready(function(){        
    menuSidebar.map((item,index)=>{
        $('#menu-sidebar').append(item)                
    })    
})

const modalLogout = `<div id="modal-logout" class="position-fixed d-none w-100" style="z-index: 10;">
                        <div class="barrier" style="height: 100vh; width: 100%; background: rgba(0, 0, 0, 0.495);">--</div>

                        <div class="card border-primary border-3 bg-warning br-15 position-absolute" style="width: 300px; top:30%; left: 39%;">
                            <div class="card-body">
                                <div class="br-15 border-primary p-4 py-5 border-3 bg-white d-flex align-items-center justify-content-center">
                                    Do you realy wana logout ?
                                </div>
                                <div class="mt-3 d-flex justify-content-around">
                                    <button id="close-logout" class="btn border-light border-3 bg-danger w-100 mx-2 text-light">No</button>
                                    <a href="login.html" class="btn border-light border-3 bg-info w-100 mx-2 text-light">Yes</a>
                                </div>
                            </div>
                        </div>
                        </div>`



$(document).on('click', '#btn-logout', function(){
    $('#main-content').after(modalLogout)
    $('#modal-logout').removeClass('d-none')    
})
$(document).on('click', '#close-logout', function(){    
    $('#modal-logout').remove()
})

