<?php include 'view/common/first_validation.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management DIK Group</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- icon -->
    <link rel="icon" href="dist/img/icon.png">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Prism.js CSS -->
    <link rel="stylesheet" href="plugins/prism/prism.css">



    <style>
        pre[class*="language-"] {
            background: #1e1e1e !important;
            color: #ffffff !important;
            border-radius: 8px;
            padding: 16px;
            font-size: 14px;
            overflow-x: auto;
        }

        hr{
            border-top: 1px solid rgb(0 0 0 / 40%);
        }

        .user .image-wrapper{
            margin : 5px 0 -95px 0 ;
        }

        .download-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 6px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            display: none;
            z-index: 999;
        }

        .image-wrapper:hover .download-btn {
            display: block;
        }

        .select2-container .select2-selection--single {
            height: 30px !important;
            padding: 2px 8px;
            font-size: 13px;
        }

        #drop-area.dragover {
            display: flex !important;
        }

        .download-btn:hover{
            color:rgb(250, 255, 113);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 30px !important;
        }

        .setting-list label {
            font-size: 13px;
            margin-top: 6px;
            margin-bottom: 2px;
        }

        .table td, .table th{
          padding: 0.5rem;
        }
        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
          .taskTableAdd{
            overflow: none;
          }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
          .taskTableAdd{
            overflow: auto;
          }
          .minWidth350{
            min-width: 350px;
          }
          .minWidth250{
            min-width: 250px;
          }
          .minWidth150{
            min-width: 150px;
          }
        }





        .image-wrapper {
            position: relative;
            display: flex;
            width: fit-content;
            margin: -20px 0 -50px 0;
            border-radius: 8px;
            min-height: 50px;
        }

        .image-wrapper img {
            display: block;
            max-width: 300px !important;
            border-radius: 8px;
            transition: opacity 0.5s ease;
        }

        .image-wrapper video {
            display: block;
            max-width: 300px !important;
            border-radius: 8px;
            transition: opacity 0.5s ease;
        }

        .image-loading {
            position: absolute;
            display: flex;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .fade-in-image {
            z-index: 2;
            position: relative;
            opacity: 0;
        }








.copy-btn {
    margin-left: auto;
}
.code-block-wrapper {
    border: 1px solid #333;
    border-radius: 6px;
    overflow: hidden;
    margin: 1em 0;
    background: #1e1e1e;
    display: flex;
    flex-direction: column;
}

.code-block-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 12px;
    background: #2d2d2d;
    font-family: monospace;
    font-size: 0.85em;
    color: #d4d4d4;
    border-bottom: 1px solid #444;
}


.copy-btn {
    background: none;
    color: #ccc;
    border: none;
    font-size: 0.8em;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 2px 6px;
}

.copy-btn:hover {
    color: white;
}



    #chat-box {
        max-height: 525px;
        overflow-y: auto;
        padding: 10px;
        display: flex;
        flex-direction: column;
    }

    .chat-bubble {
        max-width: 75%;
        padding: 10px;
        border-radius: 15px;
        margin: 5px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap; /* Memastikan format teks tetap terjaga */
    }


    .user {
        background-color: #007bff;
        color: white;
        align-self: flex-end;
    }


    .ai {
        background-color: #f1f1f1;
        color: black;
        align-self: flex-start;
    }

    .chat-sidebar {
        width: 250px;
        transition: width 0.3s ease-in-out;
    }

    .chat-sidebar.collapsed {
        width: 50px;
    }

    .chat-sidebar .search-bar,
    .chat-sidebar .chat-list,
    .chat-sidebar .setting-list,
    .chat-sidebar #new-chat {
        transition: margin-left 0.3s ease-in-out 0.3s, opacity 0.3s ease-in-out 0.3s;
    }

    .chat-sidebar.collapsed .search-bar,
    .chat-sidebar.collapsed .chat-list,
    .chat-sidebar.collapsed .setting-list,
    .chat-sidebar.collapsed #new-chat {
        margin-left: -90%;
        opacity: 0;
        pointer-events: none;
    }

    .chat-list {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        background: #f8f9fa;
        height: 235px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .setting-list {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        background: #f8f9fa;
        height: 235px;
        overflow-x: hidden;
    }
    .chat-list-item {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
        width: 220px;
    }
    .chat-list-item:hover {
        background-color: #e9ecef;
    }
    .search-bar{
        width: 80%;
    }
    #toggle-sidebar {
        flex-shrink: 0;
        flex-basis: 40px; /* Ukuran tetap */
        min-width: 40px;
        text-align: center;
    }
    #new-chat {
        width: 250px;
    }
    .new-chat-list{
        overflow: hidden;
    }
    #prompt {
        height: 40px; /* Set tinggi awal */
        min-height: 40px;
        max-height: 120px; /* Maksimal 4 baris sebelum muncul scrollbar */
        overflow-y: auto;
        resize: none; /* Mencegah resize manual */
        line-height: 20px; /* Menyesuaikan agar 4 baris tetap di 120px */
    }

    .chat-list-item.active-chat {
        background: rgba(0, 123, 255, 0.1); /* Biru muda transparan */
        border-left: 4px solid #007bff; /* Garis di kiri untuk penanda */
        border-radius: 5px;
        transition: background 0.2s ease-in-out;
    }

    @media (max-width: 700px) {
        #chat-box, #chat-form {
            transition: opacity 0.3s ease-in-out;
            display: none; /* Sembunyikan dari awal untuk mencegah kedipan */
        }
        .chat-bubble{
            max-width: 100%;
            margin-bottom: 20px;
        }
        .ai{
            margin-right: 50px;
        }
        .user{
            margin-left: 50px;
        }
        .image-wrapper img {
            max-width: 100px !important;
        }
        .image-wrapper{
            min-height: auto !important;
        }
    }

    #preview-image-container img {
        max-width: 200px;
        height: auto;
        border-radius: 10px;
    }

    .card-body {
        overflow: hidden;
        flex-wrap: wrap; /* agar jika terlalu sempit, bisa membungkus konten */
        }



     /* Background modal transparan hitam */
    .modal-backdrop.show {
        opacity: 0.85;
        background-color: black;
    }

    /* Biar tombol close tidak terlalu besar di mobile */
    .btn-close {
        width: 1.5rem;
        height: 1.5rem;
    }

    @media (max-width: 768px) {
        #aiModalImage {
        max-height: 70vh;
        }
    }

</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include "./view/common/navbar.php" ?>
        <?php include "./view/common/aside.php" ?>
        <div class="content-wrapper">


        <!-- Modal Gambar AI -->
        <div class="modal fade" id="aiImageModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: unset;">
                <div class="modal-content bg-transparent border-0 d-flex justify-content-center align-items-center">

                <!-- Wrapper gambar -->
                <div class="position-relative d-inline-block">
                    <!-- Tombol Close -->
                    <button type="button" class="position-absolute d-flex justify-content-center align-items-center" 
                            data-bs-dismiss="modal" aria-label="Close"
                            style="top: 8px; right: 8px; z-index: 10; background-color: rgba(255, 0, 0, 0.7); width: 36px; height: 36px; border: none; border-radius: 5%;">
                        <i class="fas fa-times text-white" style="font-size: 18px;"></i>
                    </button>



                    <!-- Gambar -->
                    <img id="aiModalImage" src="" alt="Preview Image" class="img-fluid rounded shadow"
                        style="max-height: 90vh; width: auto; max-width: 95vw;" />
                </div>

                </div>
            </div>
        </div>





            
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-2">
                                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Chat with AI</h3>
                                    <input type="hidden" id="chat-title-ai" class="chat-title-ai" data-id="">
                                </div>
                                <div class="card-body d-flex">
                                    <div class="chat-sidebar" id="chat-sidebar">
                                        <div class="d-flex">
                                            <input type="text" class="search-bar form-control" placeholder="Search title chat...">
                                            <button class="btn btn-primary btn-sm ml-2" id="toggle-sidebar"><i class="fas fa-compress-alt"></i></button>
                                        </div>
                                        <div class="chat-list mt-2">
                                        </div>
                                        <div class="setting-list mt-2">
                                            <div style="width: 220px;">
                                                <h5>Setting Images Output</h5>
                                                <label for="type_ai" class="form-label">Image AI Type</label>
                                                <select id="type_ai" class="form-select select2">
                                                    <option value="free" selected>Free (Pollinations)</option>
                                                    <option value="diffusion">Diffusion (Illustration)</option>
                                                    <option value="black-forest">Black Forest (Realistic)</option>
                                                    <option value="kling">Kling (Video Generator)</option>
                                                </select>

                                                <label for="upscale" class="form-label mt-2">Upscale</label>
                                                <select id="upscale" class="form-select select2">
                                                    <option value="default" selected>Default</option>
                                                    <option value="2">2x</option>
                                                    <option value="4">4x</option>
                                                </select>

                                                <label for="aspect_ratio" class="form-label mt-2">Aspect Ratio</label>
                                                <select id="aspect_ratio" class="form-select select2">
                                                    <option value="1:1" selected>1:1 (Square)</option>
                                                    <option value="16:9">16:9 (Wide)</option>
                                                    <option value="4:5">4:5 (Instagram)</option>
                                                    <option value="9:16">9:16 (Portrait)</option>
                                                    <option value="3:4">3:4</option>
                                                    <option value="4:3">4:3</option>
                                                    <option value="2:3">2:3</option>
                                                    <option value="3:2">3:2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="new-chat-list">
                                            <button class="btn btn-primary mt-3" id="new-chat"><i class="fas fa-plus"></i> New Chat</button>
                                        </div>
                                    </div>

                                    <div class="flex-grow-1 ml-3 d-flex flex-column" style="width: 75%; height: 585px;">


                                        <!-- Drag & Drop Area, awalnya hidden -->
                                        <div id="drop-area" class="p-2 text-center" 
                                            style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); border: 2px dashed #28a745; border-radius: 5px; color: #333; font-size: 16px; z-index: 10; align-items: center; justify-content: center;">
                                            Drop your file here!
                                        </div>


                                        <div id="chat-box" class="p-3 position-relative flex-grow-1" style="min-height: 200px; overflow-y: auto; background: #f8f9fa; border: 1px solid #ccc; border-radius: 5px;">

                                        </div>

                                        <form id="chat-form" class="mt-3" enctype="multipart/form-data">

                                            <!-- PREVIEW IMAGE DI ATAS TEXTAREA -->
                                            <div id="preview-image-container" class="mb-2 d-flex flex-wrap gap-2" style="display: none !important;"></div>

                                            <!-- INPUT GROUP -->
                                            <div class="input-group mb-2">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-paperclip"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item attach-option" href="#" data-type="image">📷 Image</a>
                                                        <a class="dropdown-item attach-option" href="#" data-type="video">🎬 Video</a>
                                                        <a class="dropdown-item attach-option" href="#" data-type="document">📄 Document</a>
                                                        <a class="dropdown-item attach-option" href="#" data-type="audio">🎵 Audio</a>
                                                    </div>
                                                </div>


                                                <!-- Hidden file input -->
                                                <input type="file" id="file-input" style="display: none;" multiple>


                                                <textarea id="prompt" class="form-control" placeholder="Type your prompt..." rows="2"></textarea>

                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-success">Send</button>
                                                </div>
                                            </div>

                                            <div id="file-name" class="mt-2" style="font-size: 14px; color: #333;"></div>
                                        </form>


                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'view/common/footer.html'; ?>
    </div>

    
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


    <!-- Bootstrap JS (gunakan bundle agar ada modal, popper, dll) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <script type="text/javascript">
    <?php if($_SESSION['statusX']==1){ ?>
        $(window).on('load', function() {
            $('#modal-update-password2').modal({backdrop: 'static', keyboard: false});
            $('#modal-update-password2').modal('show');
        });
    <?php } ?>

    <?php if($_SESSION['tidak_lengkap']==1){ ?>
        $(window).on('load', function() {
            $('#modal-profile').modal('show');
        });
    <?php } ?>
    </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/prism/prism.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    

    <script>

    $(document).ready(function () {
        // Event untuk image preview modal
       $(document).on('click', '.image-wrapper img', function (e) {
            // Abaikan jika klik pada tombol download
            if ($(e.target).closest('.download-btn').length > 0) return;

            const src = $(this).attr('src');
            if (!src) return;

            console.log('Image clicked'); // Pastikan ini muncul

            $('#aiModalImage').attr('src', src);
            $('#aiImageModal').modal('show');
        });

    });


        


    // Inisialisasi
    let attachedFiles = [];
    
    let fileInput = document.getElementById("file-input");
    let previewContainer = document.getElementById("preview-image-container");
    


    // Mapping ekstensi dan batas ukuran (dalam MB)
    const allowedTypes = {
        image: { extensions: ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'tiff'], maxSizeMB: 2 },
        video: { extensions: ['mp4', 'avi', 'mov', 'mkv', 'webm', 'flv', 'wmv', 'm4v'], maxSizeMB: 50 },
        audio: { extensions: ['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a'], maxSizeMB: 10 },
        document: {
            extensions: ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'odt', 'ods', 'odp', 'rtf',
                'apk', 'exe', 'dmg', 'iso', 'html', 'css', 'js', 'php', 'py', 'java', 'cpp', 'c', 'cs', 'json', 'xml',
                'sql', 'md', 'zip', 'rar', '7z', 'tar', 'gz', 'bz2', 'xz'],
            maxSizeMB: 20
        }
    };

    function getFileCategory(extension) {
        extension = extension.toLowerCase();
        for (const [category, data] of Object.entries(allowedTypes)) {
            if (data.extensions.includes(extension)) {
                return category;
            }
        }
        return null;
    }

    function isFileAllowed(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        const category = getFileCategory(ext);
        if (!category) return { allowed: false, reason: "Tipe file tidak diizinkan." };

        const maxSizeMB = allowedTypes[category].maxSizeMB;
        if (file.size > maxSizeMB * 1024 * 1024) {
            return { allowed: false, reason: `Ukuran file ${file.name} melebihi batas ${maxSizeMB} MB.` };
        }

        return { allowed: true };
    }

        // Handler perubahan file (upload)
        fileInput.addEventListener("change", function () {
            const newFiles = Array.from(fileInput.files);

            newFiles.forEach(file => {
                const validation = isFileAllowed(file);
                if (!validation.allowed) {
                    toastr.error(validation.reason);
                    return;
                }

                const isDuplicate = attachedFiles.some(f => f.name === file.name && f.size === file.size);
                if (!isDuplicate) {
                    attachedFiles.push(file);
                    renderPreview(file);
                }
            });


            fileInput.value = ""; // Reset agar bisa pilih file yang sama lagi
            updatePreviewContainerDisplay();
        });

        // Saat opsi dari dropdown "Attach" diklik
        document.querySelectorAll(".attach-option").forEach(option => {
            option.addEventListener("click", function (e) {
                e.preventDefault();

                const type = this.dataset.type;
                let accept = "";

                if (type === "image") accept = "image/*";
                else if (type === "video") accept = "video/*";
                else if (type === "document") accept = ".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt";
                else if (type === "audio") accept = "audio/*";

                fileInput.setAttribute("accept", accept);
                fileInput.click();
            });
        });

        // Fungsi render preview file
        function renderPreview(file) {
            const wrapper = document.createElement("div");
            wrapper.className = "position-relative d-inline-block me-2";
            wrapper.style.maxWidth = "200px";

            const removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.className = "btn btn-sm btn-danger position-absolute";
            removeBtn.style.top = "5px";
            removeBtn.style.right = "5px";
            removeBtn.innerHTML = "&times;";
            removeBtn.onclick = () => {
                attachedFiles = attachedFiles.filter(f => !(f.name === file.name && f.size === file.size));
                previewContainer.removeChild(wrapper);
                updatePreviewContainerDisplay();
            };

            if (file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.className = "img-thumbnail";
                    img.style.height = "120px";
                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            } else if (file.type.startsWith("video/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const videoWrapper = document.createElement("div");
                    videoWrapper.style.position = "relative";
                    videoWrapper.style.height = "120px";
                    videoWrapper.className = "border rounded overflow-hidden";

                    const video = document.createElement("video");
                    video.src = e.target.result;
                    video.controls = true;
                    video.style.width = "100%";
                    video.style.height = "100%";
                    videoWrapper.appendChild(video);

                    wrapper.appendChild(videoWrapper);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            }  else if (file.type.startsWith("audio/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const audio = document.createElement("audio");
                    audio.controls = true;
                    audio.src = e.target.result;
                    audio.style.height = "120px";

                    const audioBox = document.createElement("div");
                    audioBox.className = "border rounded p-2 bg-light";
                    audioBox.appendChild(audio);

                    wrapper.appendChild(audioBox);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            } else {
                // Default for document (pdf, doc, etc.)
                const icon = document.createElement("div");
                icon.className = "bg-light p-2 border rounded text-truncate";
                icon.style.height = "120px";
                icon.innerHTML = `
                    <i class="fas fa-file-alt fa-2x me-2 text-secondary"></i>
                    <div><strong>${file.name}</strong><br><small>${(file.size / 1024).toFixed(1)} KB</small></div>
                `;
                wrapper.appendChild(icon);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            }
        }


        // Tampilkan atau sembunyikan preview
        function updatePreviewContainerDisplay() {
            previewContainer.style.display = attachedFiles.length > 0 ? "flex" : "none";
        }

        // Drag and drop handler
        const dropArea = document.getElementById("drop-area");

        ["dragenter", "dragover"].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.add("dragover");
            }, false);
        });

        ["dragleave", "drop"].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.remove("dragover");
            }, false);
        });

        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            e.stopPropagation();
            $("#drop-area").hide();

            const droppedFiles = Array.from(e.dataTransfer.files);
            droppedFiles.forEach(file => {
                const validation = isFileAllowed(file);
                if (!validation.allowed) {
                    toastr.error(validation.reason);
                    return;
                }

                const isDuplicate = attachedFiles.some(f => f.name === file.name && f.size === file.size);
                if (!isDuplicate) {
                    attachedFiles.push(file);
                    renderPreview(file);
                }
            });


            updatePreviewContainerDisplay();
        });

        // Drag listener di chat-box
        $("#chat-box")[0].addEventListener("dragover", function (e) {
            e.preventDefault();
            const dt = e.dataTransfer;
            if (dt && dt.items && Array.from(dt.items).some(item => item.kind === "file")) {
                $("#drop-area").show();
            }
        });

        $("#chat-box")[0].addEventListener("dragleave", function (e) {
            e.preventDefault();
            $("#drop-area").hide();
        });

        $("#chat-box")[0].addEventListener("drop", function (e) {
            e.preventDefault();
            $("#drop-area").hide();
        });

        $(document).ready(function () {
            $('#type_ai').on('change', function () {
                const isFree = $(this).val() === 'free';

                $('#upscale option').prop('disabled', false);
                $('#aspect_ratio option').prop('disabled', false);

                if (isFree) {
                    $('#upscale option').each(function () {
                        if ($(this).val() !== 'default') {
                            $(this).prop('disabled', true);
                        }
                    });

                    $('#aspect_ratio option').each(function () {
                        if ($(this).val() !== '1:1') {
                            $(this).prop('disabled', true);
                        }
                    });

                    $('#upscale').val('default').trigger('change');
                    $('#aspect_ratio').val('1:1').trigger('change');
                }

                $('#upscale').trigger('change.select2');
                $('#aspect_ratio').trigger('change.select2');
            });

            $('#type_ai').trigger('change'); // jalankan saat pertama kali load juga
        });

      
        function copyCode(button) {
            const code = button.closest('.code-block-wrapper').querySelector('code').innerText;
            navigator.clipboard.writeText(code).then(() => {
                toastr.success("Copied!");
            });
        }

        $(document).ready(function () {

            $('.select2').select2({
                width: '100%'
            });
         
            let prompt = $("#prompt");

            // Set tinggi awal ke 40px
            prompt.css("height", "40px");

            // Fungsi untuk menyesuaikan tinggi textarea secara otomatis
            function adjustTextareaHeight() {
                prompt.css("height", "40px"); // Reset dulu agar ukurannya bisa dihitung ulang
                let scrollHeight = prompt.prop("scrollHeight");
                let maxHeight = 120; // Maksimal 4 baris (120px)
                let newHeight = Math.min(scrollHeight, maxHeight);
                prompt.css("height", newHeight + "px");
            }

            // Event listener saat mengetik
            prompt.on("input", function () {
                adjustTextareaHeight();
            });

            // Event listener untuk menangani Enter & Shift+Enter
            prompt.keydown(function (e) {
                if (e.key === "Enter" && !e.shiftKey) {
                    e.preventDefault(); // Cegah newline
                    $("#chat-form").submit(); // Submit form
                }
            });
 
            function createImageWithLoader(url, alt = "Generated Image") {
                // Buat elemen wrapper div
                const wrapper = document.createElement("div");
                wrapper.style.position = "relative";
                wrapper.style.display = "inline-block";
                wrapper.style.maxWidth = "50%";
                wrapper.style.margin = "10px 0";
                wrapper.style.borderRadius = "8px";

                // Buat loading spinner/teks sementara
                const loader = document.createElement("div");
                loader.innerText = "Loading image...";
                loader.style.padding = "10px";
                loader.style.textAlign = "center";
                loader.style.fontStyle = "italic";

                // Tambahkan loader ke wrapper
                wrapper.appendChild(loader);

                // Buat image baru secara dinamis
                const img = new Image();
                img.src = url;
                img.alt = alt;
                img.style.maxWidth = "100%";
                img.style.borderRadius = "8px";
                img.style.display = "none"; // Sembunyikan dulu

                // Saat gambar selesai dimuat
                img.onload = () => {
                    wrapper.removeChild(loader);
                    img.style.display = "block";
                    wrapper.appendChild(img);
                };

                // Kalau gagal load
                img.onerror = () => {
                    loader.innerText = "Failed to load image.";
                };

                return wrapper;
            }

            async function uploadFileToChatServer(file, activeChatId) {
                const formData = new FormData();
                formData.append('file_upload', file);
                formData.append('id_chat', activeChatId);
                formData.append('id_user', "<?= $id_user; ?>"); // langsung dari PHP ke JS

                try {
                    const response = await fetch('view/ajax/upload_file.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        return result.file_path;
                    } else {
                        console.error('Upload gagal:', result.message);
                        return null;
                    }
                } catch (error) {
                    console.error('Error saat upload:', error);
                    return null;
                }
            }




            $("#chat-form").submit(async function (e) {
                e.preventDefault();

                console.log("chat-form submited");
                
                let userMessage = $("#prompt").val().trim();
                if (userMessage === "") {
                    toastr.error("Please type the promt!");
                    return;
                };



                let activeChatId = $(".chat-title-ai").data("id");
                console.log("Active Chat ID before:", activeChatId); // Debugging

                if (!activeChatId) {
                    let lastChatNumber = 0;

                    $(".chat-list-item").each(function () {
                        let titleText = $(this).find(".chat-title").text();
                        let match = titleText.match(/New Chat (\d+)/);
                        if (match) {
                            let num = parseInt(match[1]);
                            if (num > lastChatNumber) lastChatNumber = num;
                        }
                    });

                    let newChatNumber = lastChatNumber + 1;
                    let chatTitle = "New Chat " + newChatNumber;

                    $.ajax({
                        url: "view/ajax/add_chat.php",
                        type: "POST",
                        dataType: "json",
                        async: false,
                        data: { title_chat: chatTitle, id_user: "<?= $id_user; ?>" },
                        success: function (response) {
                            if (response.success) {
                                activeChatId = response.id_dg_chat_ai_title;
                                $(".chat-title-ai").data("id", activeChatId).val(activeChatId);
                                loadChatList();
                                
                            } else {
                                console.error("Failed to create chat:", response.message);
                            }
                        },


                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            console.log("Server Response:", xhr.responseText);
                        }
                    });
                }
                

                // Proses upload file jika ada
                if (attachedFiles.length > 0) {
                    try {
                        const uploads = await Promise.all(attachedFiles.map(file => uploadFileToChatServer(file,activeChatId)));
                        const successfulUploads = uploads.filter(path => path !== null);
                        const failedCount = uploads.length - successfulUploads.length;

                        if (failedCount > 0) {
                            toastr.error(`${failedCount} file gagal diupload. Silakan coba lagi.`);
                            return; // Jangan lanjutkan jika ada yang gagal
                        }

                        console.log("File berhasil diupload:", successfulUploads);

                        // Reset preview jika semua berhasil
                        attachedFiles = [];
                        previewContainer.innerHTML = '';
                        updatePreviewContainerDisplay();

                        const fileTags = successfulUploads.map(path => {
                        const ext = path.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                            return `<img src="${path}" style="max-width: 100%; margin-bottom: 10px;" />`;
                        } else if (['mp4', 'webm'].includes(ext)) {
                            return `<video controls style="max-width: 100%; margin-bottom: 10px;"><source src="${path}" type="video/${ext}"></video>`;
                        } else if (['mp3', 'ogg', 'wav'].includes(ext)) {
                            return `<audio controls style="width: 100%; margin-bottom: 10px;"><source src="${path}" type="audio/${ext}"></audio>`;
                        } else {
                            return `<a href="${path}" target="_blank" style="display: block; margin-bottom: 10px;">Download File: ${path.split('/').pop()}</a>`;
                        }
                    }).join('\n');

                    userMessage = fileTags + '\n\n' + userMessage;


                    } catch (err) {
                        console.error("Terjadi error saat upload:", err);
                        toastr.error("Terjadi kesalahan saat mengupload file.");
                        return;
                    }
                }

                

                // Simpan chat user ke database
                $.ajax({
                    url: "view/ajax/save_chat.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        id_dg_chat_ai_title: activeChatId,
                        status_chat: 1, // 1 = user
                        chat_detail: userMessage
                    }),
                    success: function () {

                        let newChat = $(`.chat-list-item[data-id='${activeChatId}']`);
                        $(".chat-list-item").removeClass("active-chat");
                        newChat.addClass("active-chat");

                        function escapeHtml(text) {
                            return text
                                .replace(/&/g, "&amp;")
                                .replace(/</g, "&lt;")
                                .replace(/>/g, "&gt;")
                                .replace(/"/g, "&quot;")
                                .replace(/'/g, "&#039;");
                        }


                        let escapedMessage = formatChatDetailPreserveCodeAndFormat(userMessage).replace(/&amp;/g, '&');
                        let userBubble = $('<div class="chat-bubble user"></div>').html(escapedMessage);

                        
                        $("#chat-box").append(userBubble);
                        $("#prompt").val(""); // Kosongkan input
                        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);

                        // Tampilkan efek mengetik
                        let typingIndicator = $('<div class="chat-bubble ai typing">AI is thinking...</div>');
                        $("#chat-box").append(typingIndicator);
                        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);

                        let typingText = "AI is thinking";
                        let dotCount = 0;

                        let typingAnimation = setInterval(() => {
                            dotCount = (dotCount + 1) % 4;
                            typingIndicator.text(typingText + ".".repeat(dotCount));
                        }, 500);

                        function formatChatDetailPreserveCodeAndFormat(html) {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            let result = '';
                            doc.body.childNodes.forEach(node => {
                                result += processNode(node);
                            });

                            return result.trim();
                        }

                        
                        function processNode(node) {
                                    const allowedTags = ['STRONG', 'B', 'EM', 'I', 'U', 'BR', 'IMG', 'HR', 'H3', 'UL', 'OL', 'LI', 'VIDEO']; // Tambahkan IMG

                                    if (node.nodeType === Node.TEXT_NODE) {
                                        return escapeHtml(node.textContent);
                                    }

                                    if (node.nodeType === Node.ELEMENT_NODE) {
                                        const isCodeBlock = node.classList.contains('code-block-wrapper');
                                        const isOverflowAuto = node.getAttribute('style')?.includes('overflow-x:auto');

                                        if (isCodeBlock || isOverflowAuto) {
                                            return node.outerHTML;
                                        }

                                        const tagName = node.tagName.toUpperCase();

                                        // ✳️ Khusus <img>: izinkan tampil apa adanya dan tambahkan loading
                                        if (tagName === 'IMG') {
                                            const srcLama = escapeHtml(node.getAttribute('src') || '');

                                            // Ganti "img/ai_images/" dengan "storage/ai/img/"
                                            const src = srcLama.replace('img/ai_images/', 'storage/ai/img/');


                                            const alt = escapeHtml(node.getAttribute('alt') || '');
                                            const style = escapeHtml(node.getAttribute('style') || '');

                                            // Tambahkan event onload untuk menghapus loading
                                            const imgHtml = `
                                                <div class="image-wrapper" >
                                                    <img src="img/loading.gif" class="image-loading" alt="Loading..." 
                                                        style="position: absolute; top: 0; left: 0; width: 100%; height: auto; transition: opacity 0.5s ease;" />
                                                    
                                                    <img src="${src}" alt="${alt}" class="fade-in-image" 
                                                        style="${style}; opacity: 0; transition: opacity 0.5s ease;" 
                                                        onload="
                                                            this.style.opacity = '1';
                                                            if (this.previousElementSibling) {
                                                                this.previousElementSibling.style.opacity = '0';
                                                                setTimeout(() => this.previousElementSibling.remove(), 500);
                                                            }
                                                        "
                                                    />
                                                    <a href="${src}" download class="download-btn" title="Download"><i class="fas fa-download"></i></a>
                                                </div><br>
                                            `;



                                            return imgHtml;
                                        }

                                        if (tagName === 'VIDEO') {
                                            const srcLama = escapeHtml(node.querySelector('source')?.getAttribute('src') || '');
                                            const src = srcLama.replace('storage/upload/video/', 'storage/upload/video/'); // bisa modifikasi kalau perlu

                                            const style = escapeHtml(node.getAttribute('style') || 'max-width: 100%; margin-bottom: 10px;');

                                            const videoHtml = `
                                                <div class="image-wrapper" style="position: relative;">
                                                    <video controls style="${style}">
                                                        <source src="${src}" type="video/mp4" />
                                                        Your browser does not support the video tag.
                                                    </video>
                                                    <a href="${src}" download class="download-btn" title="Download Video"><i class="fas fa-download"></i></a>
                                                </div><br>
                                            `;

                                            return videoHtml;
                                        }


                                        // ✳️ Khusus <script>: bungkus sebagai teks
                                        if (tagName === 'SCRIPT') {
                                            return `<code>&lt;script src="${escapeHtml(node.getAttribute('src') || '')}"&gt;&lt;/script&gt;</code>`;
                                        }

                                        // ✳️ Tag lainnya yang diizinkan
                                        if (allowedTags.includes(tagName)) {
                                            return `<${tagName.toLowerCase()}>${escapeHtml(node.innerHTML)}</${tagName.toLowerCase()}>`;
                                        }

                                        // Jika bukan tag yang diizinkan: proses anak-anaknya
                                        let result = '';
                                        node.childNodes.forEach(child => {
                                            result += processNode(child);
                                        });
                                        return result;
                                    }

                                    return '';
                                }
                        

                        // **Ambil semua chat sebelumnya berdasarkan `activeChatId`**
                        $.ajax({
                            url: "view/ajax/get_chat_history.php", // Endpoint untuk mengambil history chat
                            type: "POST",
                            contentType: "application/json",
                            data: JSON.stringify({ id_dg_chat_ai_title: activeChatId }),
                            success: function (chatHistoryResponse) {
                                let chatHistory = chatHistoryResponse.history; // Array chat sebelumnya
                                //console.log("Berikut ini adalah percakapan kita sebelumnya:", chatHistory);

                                // **Gabungkan chat sebelumnya ke dalam userMessage**
                                let chatContext = "";
                                chatHistory.forEach(chat => {
                                    let role = chat.status == 1 ? "user" : "Kamu"; // 1 = User, 2 = AI
                                    chatContext += `${role}: ${chat.message}\n`; // Gabungkan chat sebelumnya
                                });

                                // Tambahkan prompt terbaru di akhir
                                let finalPrompt = "";

                                let additionalNote = "Kamu adalah system chat yang akan berbicara dengan User. Notes System (User tidak melihat ini, sehingga tidak perlu di jelaskan ke user): "
                                                     + "Jika ada permintaan gambar / video maka gunakan format ini untuk semua gambarnya / videonya ![MEDIA][promt dalam bahasa inggris]. Jika tidak, tidak perlu dibuat."
                                                     + "Sisipkan spasi / enter setelah dan sebelum ![MEDIA][prompt]."
                                                     + "Contoh: <spasi> ![MEDIA][a cat with a hat] <spasi>."
                                                     + "Jumlahnya gambar / video sesuai yang diminta, jika diminta 1 buatkan 1. Jika tidak ada jumlahnya kamu atur sendiri jumlahnya gambar / videonya." 
                                                     + "Tapi untuk video usahakan 1 saja, karena cukup berat."
                                                     + "Jangan lupa memberikan penjelasan tambahan tentang gambar tersebut."
                                                     + "Berikan jawaban menggunakan bahasa yang kamu cek dari permintaan atau percakapan user terakhir."
                                                     + "Jika permintaan user tidak jelas, kamu bisa bertanya terlebih dahulu sebelum memberikan penjelasan."
                                                     + "Diakhir selalu berikan pertanyaan rekomendasi apa lagi yang dapat kamu lakukan."
                                                     + "Kamu bisa membuat table juga jika diperlukan."
                                                     + "Gunakan emot untuk point-point header tertentu membantu user membaca lebih mudah."
                                                     + "Gunakan [hr] untuk memsihkan section-section penjelasan yang akan kamu jelaskan dan berikan judul di setiap sectionnya."
                                                     + "Semua notes ini akan kalah dengan permintaan user, jadi jika ada di notes tapi user meminta sesuatu yang lain ikuti user.";
                                                    
                                                     
                                                     
                                                    

                                if (chatContext.includes("Kamu")) {
                                    finalPrompt = `Berikut ini adalah percakapan kita sebelumnya:\n${chatContext}\nBerikut tambahan permintaan dari user: ${userMessage}\n\n${additionalNote}`;
                                } else {
                                    finalPrompt = `Berikut permintaan dari user: ${userMessage}\n\n${additionalNote}`;
                                }

                                console.log("Final Prompt Sent to API:", finalPrompt);

                                const aiType = $('#type_ai').val();        // 'free', 'diffusion', 'black-forest'
                                const upscale = $('#upscale').val();       // 'default', '2', '4'
                                const aspectRatio = $('#aspect_ratio').val(); // misalnya '1:1'

                                console.log({ aiType, upscale, aspectRatio });

                                let typeData = "mng_ai";

                                

                            // Kirim permintaan ke chat_api.php
                            $.ajax({
                                url: "view/ajax/chat_api.php",
                                type: "POST",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    prompt: finalPrompt,
                                    ai_type: aiType,
                                    upscale: upscale,
                                    aspect_ratio: aspectRatio,
                                    id_user : <?php echo $id_user; ?>,
                                    id_dg_chat_ai_title: activeChatId,
                                    type_data : typeData
                                }),

                                success: function (response) {
                                    console.log("activeChatId", activeChatId);
                                    
                                    typingIndicator.remove();
                                    console.log("AI Response RAW:", response); // Debugging

                                    let aiResponse = response && response.response ? response.response : "";

                                    // Decode HTML entities (seperti &lt; menjadi <)
                                    function decodeHtml(html) {
                                        const txt = document.createElement("textarea");
                                        txt.innerHTML = html;
                                        return txt.value;
                                    }

                                    aiResponse = decodeHtml(aiResponse);

                                    function normalizeMarkdownTables(text) {
                                        const lines = text.split("\n");
                                        let inTable = false;
                                        const normalizedLines = [];

                                        for (let i = 0; i < lines.length; i++) {
                                            let line = lines[i].trim();

                                            // Cek apakah ini baris tabel: memiliki beberapa `|`
                                            const isLikelyTableRow = (line.match(/\|/g) || []).length >= 2;

                                            // Mulai tabel jika baris punya banyak "|"
                                            if (isLikelyTableRow) {
                                                inTable = true;

                                                // Pastikan ada | di awal dan akhir
                                                if (!line.startsWith("|")) line = "| " + line;
                                                if (!line.endsWith("|")) line = line + " |";

                                                normalizedLines.push(line);
                                            } else {
                                                inTable = false;
                                                normalizedLines.push(line); // baris normal (subheading atau teks biasa)
                                            }
                                        }

                                        return normalizedLines.join("\n");
                                    }


                                    const containsMarkdownTable = /\|(.+?)\|/g.test(aiResponse) && !/<table[\s\S]*?>[\s\S]*?<\/table>/gi.test(aiResponse);

                                    if (containsMarkdownTable) {
                                        aiResponse = normalizeMarkdownTables(aiResponse);
                                    }


                                    console.log("🔍 Normalized Markdown:\n", aiResponse);


                                    // Ganti **bold** dengan <strong>
                                    aiResponse = aiResponse.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                                    
                                    // Jika jawaban kosong, tampilkan error
                                    if (!aiResponse.trim()) {
                                        aiResponse = "Error : No valid response from AI.";
                                    }

                                    // 🔥 **Fix: Cek duplikasi secara lebih ketat**
                                    let lastAiBubble = $("#chat-box .chat-bubble.ai").last();
                                    if (lastAiBubble.length > 0 && lastAiBubble.html().trim() === aiResponse.trim()) {
                                        return; // Jangan tampilkan jika jawaban terakhir sama persis
                                    }


                                        console.log("AI Formated:", aiResponse); // Debugging                

                                        aiResponse = aiResponse.replace(
  /((?:\|.+?\|\s*\n)+)/g,
                                            function (tableBlock) {
                                                const lines = tableBlock.trim().split("\n").map(l => l.trim()).filter(Boolean);
                                                if (lines.length < 2) return tableBlock;

                                                const headers = lines[0].split("|").slice(1, -1).map(cell => cell.trim());
                                                const headerCount = headers.length;
                                                const headerHTML = headers.map(cell => `<th>${cell}</th>`).join("");

                                                const bodyHTML = lines.slice(2).map(line => {
                                                const cells = line.split("|").slice(1, -1).map(c => c.trim());

                                                const isSubheading = cells.length < headerCount &&
                                                    (
                                                    cells.length === 1 ||
                                                    cells.filter(c => c !== "").length === 1 ||
                                                    cells.every(c => /^(\d+(\.\d+)?|[A-Z\s]+)$/.test(c))
                                                    );

                                                if (isSubheading) {
                                                    const subText = cells.join(" ").replace(/\*\*/g, "").trim();
                                                    return `<tr><td colspan="${headerCount}"><strong>${subText}</strong></td></tr>`;
                                                }

                                                const rowHTML = headers.map((_, i) => {
                                                    let cell = (cells[i] !== undefined) ? cells[i].trim() : "";

                                                    if (/\*\*/.test(cell)) {
                                                    cell = `<strong>${cell.replace(/\*\*/g, "")}</strong>`;
                                                    }

                                                    return `<td>${cell}</td>`;
                                                }).join("");

                                                return `<tr>${rowHTML}</tr>`;
                                                }).join("");

                                                return `
                                                <div style="overflow-x:auto;">
                                                    <table class="table table-bordered table-striped dataTable no-footer" style="width: 100%; min-width: max-content;">
                                                    <thead><tr>${headerHTML}</tr></thead>
                                                    <tbody>${bodyHTML}</tbody>
                                                    </table>
                                                </div>
                                                `.trim();
                                            }
                                        );
                                        
                                        Prism.highlightAll();


                                        // 🔐 Deteksi dan bungkus blok kode dari AI, baik ```html atau ``` saja
                                        aiResponse = aiResponse.replace(/```(?:([a-zA-Z]+))?\s*([\s\S]*?)\s*```/gi, function (_, lang, codeBlock) {
                                            let language = (lang && lang.trim()) ? lang.toLowerCase() : "markup"; // default ke markup (HTML)
                                            let displayLang = (lang && lang.trim())
                                                ? lang.charAt(0).toUpperCase() + lang.slice(1)
                                                : "Code";

                                            // Encode agar aman untuk ditampilkan
                                            let cleanedCode = codeBlock
                                                .replace(/&/g, "&amp;")
                                                .replace(/</g, "&lt;")
                                                .replace(/>/g, "&gt;");

                                            return `
                                                <div class="code-block-wrapper">
                                                    <div class="code-block-header">
                                                        <div class="code-lang">${displayLang}</div>
                                                        <button class="copy-btn" onclick="copyCode(this)"><i class="fas fa-copy"></i> Copy</button>
                                                    </div>
                                                    <pre class="ai-code-block language-${language}"><code class="language-${language}">${cleanedCode}</code></pre>
                                                </div>
                                            `.trim();
                                        });

                                        let htmlBlocks = [];
                                            aiResponse = aiResponse.replace(/<([a-z][\s\S]*?)<\/\1>/gi, function(match) {
                                                htmlBlocks.push(match);
                                                return `__HTML_BLOCK_${htmlBlocks.length - 1}__`;
                                            });


                                        aiResponse = aiResponse
                                                .replace(/```html\s*<br\s*\/?>/gi, "")       // Hapus ```html<br />
                                                .replace(/<br\s*\/?>\s*```/gi, "")           // Hapus <br>```
                                                .replace(/\s*<br\s*\/?>\s*/gi, "\n")         // Semua <br> jadi \n
                                                .replace(/\n{3,}/g, "\n\n")                  // Maksimal 2 newline
                                                .replace(/(<strong>\n)/g, "<strong>")        // Bersihin newline setelah <strong>
                                                .replace(/(\n<\/strong>)/g, "</strong>")     // Bersihin newline sebelum </strong>
                                                .replace(/(\* )\n/g, "$1")                   // Hapus newline setelah bullet
                                                .replace(/>\s*\n\s*</g, "><")                // ❗❗ Hapus newline antar tag HTML (opsional)
                                                .trim();



                                        aiResponse = aiResponse.replace(/`<\s*\/?\s*([^>]+?)\s*>`/g, (_, tagContent) => {
                                            return tagContent.trim();
                                        });



                                       // Ganti image markdown ![alt](link) jadi <img ...>
                                        aiResponse = aiResponse.replace(/!\[(.*?)\]\((https?:\/\/[^\s]+)\)/g, function (match, alt, url) {
                                            return `<img style="max-width: 300px;" src="${url}" alt="${alt}"  />`;
                                        });

                                        

                                        // 🔧 Tambahkan class + style + wrap div untuk setiap <table>
                                        aiResponse = aiResponse.replace(/<table([\s\S]*?)<\/table>/gi, function(match) {
                                            let tableWithClassAndStyle = match.replace(
                                                /<table([^>]*)>/i,
                                                function(_, attrs) {
                                                    // Tambahkan atau gabungkan class
                                                    if (/class\s*=/.test(attrs)) {
                                                        attrs = attrs.replace(/class=["'](.*?)["']/, 'class="$1 table table-bordered table-striped dataTable no-footer"');
                                                    } else {
                                                        attrs += ' class="table table-bordered table-striped dataTable no-footer"';
                                                    }

                                                    // Tambahkan atau gabungkan style
                                                    if (/style\s*=/.test(attrs)) {
                                                        attrs = attrs.replace(/style=["'](.*?)["']/, function(_, styleVal) {
                                                            return `style="${styleVal}; width: 100%; min-width: max-content;"`;
                                                        });
                                                    } else {
                                                        attrs += ' style="width: 100%; min-width: max-content;"';
                                                    }

                                                    return `<table${attrs}>`;
                                                }
                                            );

                                            return `<div style="overflow-x:auto;">${tableWithClassAndStyle}</div>`;
                                        });

                                    aiResponse = aiResponse.replace(/\[hr\]/gi, "<hr>");

                                    aiResponse = aiResponse.replace(/^### (.*?)(?:\n|$)/gm, '<h3>$1</h3>\n');

                                        


                                    console.log("AI Formatted Final:", aiResponse); // Debugging           

                                    // Simpan jawaban AI ke database
                                    $.ajax({
                                        url: "view/ajax/save_chat.php",
                                        type: "POST",
                                        contentType: "application/json",
                                        data: JSON.stringify({
                                            id_dg_chat_ai_title: activeChatId,
                                            status_chat: 2, // 2 = AI
                                            chat_detail: aiResponse
                                        }),
                                        success: function () {
                                            loadChatList();
                                            // Fix: Efek mengetik lebih natural, termasuk tag HTML
                                            let rawTokens = aiResponse.match(/<[^>]+>|[^<]+/g); // Pisahkan tag dan teks biasa
                                            let queue = [];

                                            // Proses awal: ubah teks biasa menjadi huruf per huruf
                                            rawTokens.forEach(token => {
                                                if (token.match(/^<[^>]+>$/)) {
                                                    // Langsung dorong tag HTML seperti <br>, <img>, <strong>, dll
                                                    queue.push(token);
                                                } else {
                                                    // Teks biasa, pecah jadi huruf
                                                    token.split('').forEach(char => queue.push(char));
                                                }
                                            });

                                            let aiBubble = $('<div class="chat-bubble ai"></div>');
                                            $("#chat-box").append(aiBubble);
                                            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);

                                            let charsPerTick = 3;

                                            let typingEffect = setInterval(function () {
                                                for (let i = 0; i < charsPerTick && queue.length > 0; i++) {
                                                    let current = queue.shift();

                                                    if (current.match(/^<img[^>]*>$/i) || current.toLowerCase().startsWith("<br") || current === "<strong>" || current === "</strong>") {
                                                        aiBubble.append(current);
                                                    } else {
                                                        let lastStrong = aiBubble.children("strong").last();
                                                        if (lastStrong.length > 0 && lastStrong.text() === "") {
                                                            lastStrong.append(current);
                                                        } else {
                                                            aiBubble.append(current);
                                                        }
                                                    }
                                                }

                                                if (queue.length === 0) {
                                                    clearInterval(typingEffect);
                                                    refreshChatFromServer();
                                                }

                                                $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                                            }, 10); // Tetap smooth, tapi muncul 3 huruf tiap 20ms


                                        }
                                    });
                                },

                                error: function () {
                                    typingIndicator.remove();
                                    $("#chat-box").append('<div class="chat-bubble ai error">Error: Server not responding.</div>');
                                }
                            });

                        }
                    });



                    }
                });
            });

            function refreshChatFromServer() {
                let chatId = $(".chat-title-ai").val(); // ✅ Update Active Chat ID

                $.ajax({
                    url: "view/ajax/get_chat.php",
                    type: "POST",
                    dataType: "json",
                    data: { id_dg_chat_ai_title: chatId },
                    success: function (response) {
                        let chatBox = $("#chat-box");
                        chatBox.empty();

                        if (response.success) {
                            response.data.forEach(chat => {
                                let bubbleClass = chat.status_chat == 1 ? "user" : "ai";
                                let formattedDetail = chat.chat_detail;

                                formattedDetail = formattedDetail.replace(/^### (.*?)(?:\n|$)/gm, '<h3>$1</h3>\n');

                               
                                formattedDetail = formatChatDetailPreserveCodeAndFormat(formattedDetail).replace(/&amp;/g, '&');
                                


                                function escapeHtml(text) {
                                    return text
                                        .replace(/&/g, "&amp;")
                                        .replace(/</g, "&lt;")
                                        .replace(/>/g, "&gt;")
                                        .replace(/"/g, "&quot;")
                                        .replace(/'/g, "&#039;")
                                        .replace(/`/g, "&#96;"); // ini penting untuk kasus kamu!
                                }

                                


                                function processNode(node) {
                                    const allowedTags = ['STRONG', 'B', 'EM', 'I', 'U', 'BR', 'IMG', 'HR', 'H3', 'UL', 'OL', 'LI', 'VIDEO']; // Tambahkan IMG

                                    if (node.nodeType === Node.TEXT_NODE) {
                                        return escapeHtml(node.textContent);
                                    }

                                    if (node.nodeType === Node.ELEMENT_NODE) {
                                        const isCodeBlock = node.classList.contains('code-block-wrapper');
                                        const isOverflowAuto = node.getAttribute('style')?.includes('overflow-x:auto');

                                        if (isCodeBlock || isOverflowAuto) {
                                            return node.outerHTML;
                                        }

                                        const tagName = node.tagName.toUpperCase();

                                        // ✳️ Khusus <img>: izinkan tampil apa adanya dan tambahkan loading
                                        if (tagName === 'IMG') {
                                            const srcLama = escapeHtml(node.getAttribute('src') || '');

                                            // Ganti "img/ai_images/" dengan "storage/ai/img/"
                                            const src = srcLama.replace('img/ai_images/', 'storage/ai/img/');


                                            const alt = escapeHtml(node.getAttribute('alt') || '');
                                            const style = escapeHtml(node.getAttribute('style') || '');

                                            // Tambahkan event onload untuk menghapus loading
                                            const imgHtml = `
                                                <div class="image-wrapper" >
                                                    <img src="img/loading.gif" class="image-loading" alt="Loading..." 
                                                        style="position: absolute; top: 0; left: 0; width: 100%; height: auto; transition: opacity 0.5s ease;" />
                                                    
                                                    <img src="${src}" alt="${alt}" class="fade-in-image" 
                                                        style="${style}; opacity: 0; transition: opacity 0.5s ease;" 
                                                        onload="
                                                            this.style.opacity = '1';
                                                            if (this.previousElementSibling) {
                                                                this.previousElementSibling.style.opacity = '0';
                                                                setTimeout(() => this.previousElementSibling.remove(), 500);
                                                            }
                                                        "
                                                    />
                                                    <a href="${src}" download class="download-btn" title="Download"><i class="fas fa-download"></i></a>
                                                </div><br>
                                            `;



                                            return imgHtml;
                                        }


                                        if (tagName === 'VIDEO') {
                                            const srcLama = escapeHtml(node.querySelector('source')?.getAttribute('src') || '');
                                            const src = srcLama.replace('storage/upload/video/', 'storage/upload/video/'); // bisa modifikasi kalau perlu

                                            const style = escapeHtml(node.getAttribute('style') || 'max-width: 100%; margin-bottom: 10px;');

                                            const videoHtml = `
                                                <div class="image-wrapper" style="position: relative;">
                                                    <video controls style="${style}">
                                                        <source src="${src}" type="video/mp4" />
                                                        Your browser does not support the video tag.
                                                    </video>
                                                    <a href="${src}" download class="download-btn" title="Download Video"><i class="fas fa-download"></i></a>
                                                </div><br>
                                            `;

                                            return videoHtml;
                                        }

                                        // ✳️ Khusus <script>: bungkus sebagai teks
                                        if (tagName === 'SCRIPT') {
                                            return `<code>&lt;script src="${escapeHtml(node.getAttribute('src') || '')}"&gt;&lt;/script&gt;</code>`;
                                        }

                                        // ✳️ Tag lainnya yang diizinkan
                                        if (allowedTags.includes(tagName)) {
                                            return `<${tagName.toLowerCase()}>${escapeHtml(node.innerHTML)}</${tagName.toLowerCase()}>`;
                                        }

                                        // Jika bukan tag yang diizinkan: proses anak-anaknya
                                        let result = '';
                                        node.childNodes.forEach(child => {
                                            result += processNode(child);
                                        });
                                        return result;
                                    }

                                    return '';
                                }



                                // Ini dipisahkan agar lebih modular dan bisa dipakai di atas
                                function processInnerNodes(node) {
                                    let inner = '';
                                    node.childNodes.forEach(child => {
                                        inner += processNode(child);
                                    });
                                    return inner;
                                }





                                function formatChatDetailPreserveCodeAndFormat(html) {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');

                                    let result = '';
                                    doc.body.childNodes.forEach(node => {
                                        result += processNode(node);
                                    });

                                    return result.trim();
                                }


                                chatBox.append(`<div class="chat-bubble ${bubbleClass}">${formattedDetail}</div>`);
                            });
                        } else {
                            chatBox.append('<div class="text-muted">No chats available.</div>');
                        }
                        Prism.highlightAll();

                        chatBox.scrollTop(chatBox[0].scrollHeight);
                    }
                });
            }


            $(document).on("click", ".chat-list-item", function () {
                let chatId = $(this).data("id");
                $(".chat-title-ai").data("id", chatId).val(chatId); // ✅ Update Active Chat ID
                
                $(".chat-list-item").removeClass("active-chat");
                $(this).addClass("active-chat");

                refreshChatFromServer();
            });

            // 🔍 **Event untuk Search Bar**
            $(document).on("input", ".search-bar", function () {
                let searchText = $(this).val().trim().toLowerCase();
                loadChatList(searchText);
            });


            // 🗂 **Load daftar chat (Mendukung Pencarian)**
            function loadChatList(searchText = "") {
                $.ajax({
                    url: "view/ajax/get_chat_list.php",
                    type: "POST",
                    dataType: "json",
                    data: { 
                        id_user: "<?= $id_user; ?>",
                        search: searchText // Kirim teks pencarian ke server
                    },
                    success: function (response) {
                        let chatList = $(".chat-list");
                        chatList.empty();

                        if (response.success && response.data.length > 0) {
                            response.data.forEach(chat => {
                                chatList.append(`
                                    <div class="chat-list-item d-flex justify-content-between align-items-center" data-id="${chat.id_dg_chat_ai_title}">
                                        <span class="chat-title editable" data-id="${chat.id_dg_chat_ai_title}">${chat.title_chat}</span>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">...</button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item rename-chat" data-id="${chat.id_dg_chat_ai_title}" data-title="${chat.title_chat}">Rename</button>
                                                <button class="dropdown-item delete-chat" data-id="${chat.id_dg_chat_ai_title}">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });

                            let activeChatId = $(".chat-title-ai").data("id");
                            let newChat = $(`.chat-list-item[data-id='${activeChatId}']`);
                            $(".chat-list-item").removeClass("active-chat");
                            newChat.addClass("active-chat");
                        } else {
                            chatList.append('<div class="text-muted">No chats found.</div>');
                        }
                    }
                });
            }

            // 🔄 **Load daftar chat saat halaman dimuat**
            loadChatList();

            $("#new-chat").click(function () {
                let lastChatNumber = 0;

                // Cari nomor terbesar dari chat yang sudah ada
                $(".chat-list-item").each(function () {
                    let titleText = $(this).find(".chat-title").text();
                    let match = titleText.match(/New Chat (\d+)/);
                    if (match) {
                        let num = parseInt(match[1]);
                        if (num > lastChatNumber) lastChatNumber = num;
                    }
                });

                let newChatNumber = lastChatNumber + 1;
                let chatTitle = "New Chat " + newChatNumber;

                $.ajax({
                    url: "view/ajax/add_chat.php",
                    type: "POST",
                    dataType: "json",
                    data: { title_chat: chatTitle, id_user: "<?= $id_user; ?>" },
                    success: function (response) {
                        activeChatId = response.id_dg_chat_ai_title;
                        $(".chat-title-ai").data("id", activeChatId).val(activeChatId);
                        //console.log("Active Chat ID before:", activeChatId); // Debugging

                        let chatBox = $("#chat-box");
                        chatBox.empty();

                        if (response.success) {
                            toastr.success("Chat added successfully!");
                            loadChatList();

                            let activeChatId = $(".chat-title-ai").data("id");
                            //console.log("Active Chat ID AI:", activeChatId); // Debugging

                        } else {
                            toastr.error("Failed to add new chat.");
                        }

                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.log("Server Response:", xhr.responseText);
                    }
                }).done(function(response) {
                    let newChat = $(`.chat-list-item[data-id='30']`);
                });

                


            });



            function enableEditMode(element) {
                let chatId = element.data("id");
                let oldTitle = element.text().trim();
                let inputField = $(`<input type="text" class="form-control edit-input" data-id="${chatId}" value="${oldTitle}" />`);
                
                element.replaceWith(inputField);
                inputField.focus();
                inputField.select(); // Select semua teks dalam input

                // Saat klik di luar input, hanya simpan jika masih dalam mode edit
                $(document).on("mousedown.rename", function (e) {
                    if (!$(e.target).hasClass("edit-input")) {
                        saveEdit(inputField);
                    }
                });
            }

            $(document).on("dblclick", ".chat-title", function () {
                enableEditMode($(this));
            });

            $(document).on("click", ".rename-chat", function () {
                let chatId = $(this).data("id");
                let chatTitleElement = $(`.chat-title[data-id="${chatId}"]`);
                enableEditMode(chatTitleElement);
            });

            function saveEdit(inputField) {
                let newTitle = inputField.val().trim();
                let chatId = inputField.data("id");
                let oldTitle = inputField.attr("value");

                if (newTitle === "") {
                    newTitle = oldTitle;
                }

                $.ajax({
                    url: "view/ajax/update_chat.php",
                    type: "POST",
                    dataType: "json",
                    data: { id_dg_chat_ai_title: chatId, title_chat: newTitle },
                    success: function (response) {
                        if (response.success) {
                            toastr.success("Chat renamed successfully!");
                            inputField.replaceWith(`<span class="chat-title editable" data-id="${chatId}">${newTitle}</span>`);
                        } else {
                            toastr.error("Failed to rename chat.");
                            inputField.replaceWith(`<span class="chat-title editable" data-id="${chatId}">${oldTitle}</span>`);
                        }
                        $(document).off("mousedown.rename"); // Matikan event listener setelah save
                    }
                });
            }

            $(document).on("keydown", ".edit-input", function (e) {
                let inputField = $(this);

                if (e.key === "Escape") {
                    inputField.replaceWith(`<span class="chat-title editable" data-id="${inputField.data("id")}">${inputField.attr("value")}</span>`);
                    $(document).off("mousedown.rename"); // Matikan event listener setelah cancel
                } else if (e.key === "Enter") {
                    saveEdit(inputField);
                }
            });

            $(document).on("click", ".delete-chat", function () {
                let chatId = $(this).data("id");
                if (confirm("Are you sure you want to delete this chat?")) {
                    $.ajax({
                        url: "view/ajax/delete_chat.php",
                        type: "POST",
                        dataType: "json",
                        data: { id_dg_chat_ai_title: chatId, id_user: "<?= $id_user; ?>"  },
                        success: function (response) {
                            if (response.success) {
                                toastr.success("Chat deleted successfully!");

                                // Kosongkan chat-box & reset chat-title-ai
                                $("#chat-box").empty();
                                $("#chat-title-ai").val("").attr("data-id", "");
                                
                                console.log("Active Chat ID after delete:", chatId); // Debugging

                                // Muat ulang daftar chat
                                loadChatList(() => {
                                    setTimeout(() => {
                                        let firstChat = $(".chat-list-item").first();
                                        if (firstChat.length > 0) {
                                            firstChat.click();
                                        }
                                    }, 100); // Delay 100ms untuk memastikan DOM selesai render
                                });

                            } else {
                                toastr.error("Failed to delete chat.");
                            }
                        }
                    });
                }
            });

            
            checkConnection();
            setInterval(checkConnection, 3000); // Cek setiap 3 detik

        });

        $(document).ready(function () {
            // Cek apakah tampilan di HP saat pertama kali load
            if (window.innerWidth <= 700) {
                if ($("#chat-sidebar").hasClass("collapsed")) {
                    $("#chat-box, #chat-form").fadeIn(300); // Animasi muncul lebih smooth
                } else {
                    $("#chat-box, #chat-form").hide(); // Tetap tersembunyi jika sidebar terbuka
                }
            }
        });

        // Handle Toggle Sidebar
        $("#toggle-sidebar").click(function () {
            $("#chat-sidebar").toggleClass("collapsed");
            let icon = $("#chat-sidebar").hasClass("collapsed") ? "fa-expand-alt" : "fa-compress-alt";
            $(this).html('<i class="fas ' + icon + '"></i>');

            // Jika layar HP, tampilkan atau sembunyikan chat
            if (window.innerWidth <= 700) {
                if ($("#chat-sidebar").hasClass("collapsed")) {
                    $("#chat-box, #chat-form").fadeIn(300); // Smooth muncul
                } else {
                    $("#chat-box, #chat-form").fadeOut(300); // Smooth hilang
                }
            }
        });


    </script>
</body>
</html>