<!-- Floating Chat Button -->
<div id="chat-bubble-ext" class="chat-bubble-ext">
    <span class="chat-label">AI</span>
    <i class="fas fa-comment-alt"></i>
</div>



<!-- Chat Box -->
<div id="chat-box-ext" class="chat-box-ext">
    <div class="chat-header-ext">
        <div class="chat-header-left">
            <a class="btn btn-lg" style="font-size: 15px; color: white; padding: 0px 5px;" id="expand-chat" href="mng_ai.php">
                <i class="fas fa-expand-alt"></i>
            </a>
            <span style="color: white; padding-left: 10px;">MNG AI</span>
        </div>
        <div class="chat-header-right">
            <div class="dropdown d-inline">
                <button class="btn btn-lg" style="font-size: 25px; color: white; padding: 0px 5px;" id="chat-menu-ext" data-bs-toggle="dropdown" data-bs-popper="static">
                    &#8943;
                </button>
                <ul class="dropdown-menu dropdown-menu-ext" aria-labelledby="chat-menu-ext">
                    <li><a class="dropdown-item rename-chat" href="#">Rename Tittle</a></li>
                    <li><a class="dropdown-item delete-chat" href="#">Delete Tittle</a></li>
                </ul>
            </div>
            <button id="minimize-chat" class="btn btn-lg" style="font-size: 25px; color: white; padding: 0px 5px;">&times;</button>
        </div>
    </div>

    <select id="chat-history" class="chat-history">
        <option value="">New Chat</option>
    </select>

    <div class="chat-content-ext" id="chat-content-ext"></div>

        <!-- PREVIEW IMAGE DI ATAS TEXTAREA -->
        <div id="preview-image-container" class="mb-2 d-flex flex-wrap gap-2" style="display: none !important;"></div>

        <div class="chat-footer-ext">

        
            

        
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

                <textarea id="chat-input-ext" placeholder="Type a message..."></textarea>
                <button id="send-chat-ext" class="btn btn-success">Send</button>
            </div>
        </div>
    </div>

<!-- CSS untuk styling -->
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

        .user .image-wrapper{
            margin : 5px 0 -95px 0 ;
        }

        .image-wrapper:hover .download-btn {
            display: block;
        }


        .image-wrapper {
            position: relative;
            display: flex;
            width: fit-content;
            margin: -40px 0 -100px 0;
            border-radius: 8px;
            min-height: 240px;
        }

        .image-wrapper img {
            height: 100%;
            display: block;
            max-width: 200px;
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
    z-index: 1;
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


.chat-label {
    position: absolute;
    font-size: 10px;
    font-weight: bold;
    color: #007bff;
    padding: 2px 5px;
    border-radius: 4px;
    text-align: center;
}

/* Floating Chat Button */
.chat-bubble-ext {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #007bff;
    color: #fff;
    width: 60px;
    height: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    z-index: 9999;
    font-size: 24px;
    touch-action: none; /* Mencegah scroll saat drag */
}

/* Chat Box */
.chat-box-ext {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 10000;
}

/* Header Chat */
.chat-header-ext {
    background: #007bff;
    padding: 5px 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header-left {
    flex: 1;
    display: flex;
    justify-content: flex-start;
}

.chat-header-right {
    flex: 1;
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}

/* Chat History */
.chat-history {
    width: 100%;
    padding: 7px 5px;
    border: none;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
    background: #e9f3ff;
    margin-bottom: 1px;
}

/* Konten Chat */
.chat-content-ext {
    height: 300px;
    overflow-y: auto;
    padding: 10px;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: pre-wrap; 
}

/* Bubble Chat */
.chat-message-ext {
    padding: 10px;
    border-radius: 10px;
    max-width: 75%;
    margin: 5px 0;
}

.chat-message-ext.user {
    background: #007bff;
    color: white;
    align-self: flex-end;
}

.chat-message-ext.ai {
    background: #e9ecef;
    color: black;
    align-self: flex-start;
}

/* Footer Chat */
.chat-footer-ext {
    display: flex;
    padding: 10px;
    background: white;
    border-top: 1px solid #ddd;
}

#chat-input-ext {
    flex-grow: 1;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

#send-chat-ext {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 5px;
}

/* Dropdown styling */
.dropdown-menu-ext {
    z-index: 1050 !important;
    display: block !important;
    visibility: hidden;
    opacity: 0;
    position: absolute !important;
    left: -80px !important;
    transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out;
}

#chat-menu-ext.show + .dropdown-menu-ext {
    visibility: visible;
    opacity: 1;
}

    #preview-image-container img {
        max-width: 200px;
        height: auto;
        border-radius: 10px;
    }

</style>
<!-- Prism.js CSS -->
<link rel="stylesheet" href="plugins/prism/prism.css">
<?php 
    if ($first_part!="calendar.php") {
?>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/prism/prism.js"></script>
<?php
    }
?>

<script>

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
                    img.style.height = "80px";
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
                    videoWrapper.style.height = "80px";
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
                    audio.style.height = "80px";

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
                icon.style.height = "80px";
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






function copyCode(button) {
            const code = button.closest('.code-block-wrapper').querySelector('code').innerText;
            navigator.clipboard.writeText(code).then(() => {
                toastr.success("Copied!");
            });
        }
        
$(document).ready(function () {


    let isDragging = false;
    let startX, startY;

    // --- DESKTOP EVENTS ---
    $("#chat-bubble-ext").on("mousedown", function (e) {
        startX = e.pageX;
        startY = e.pageY;
        isDragging = false;
    });

    $(document).on("mousemove", function (e) {
        if (startX === undefined || startY === undefined) return;

        const dx = e.pageX - startX;
        const dy = e.pageY - startY;

        if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
            isDragging = true;
            const $bubble = $("#chat-bubble-ext");
            const offset = $bubble.offset();
            $bubble.offset({
                top: offset.top + dy,
                left: offset.left + dx,
            });
            startX = e.pageX;
            startY = e.pageY;
        }
    });

    $(document).on("mouseup", function () {
        startX = startY = undefined;
    });

    // --- MOBILE EVENTS ---
    $("#chat-bubble-ext").on("touchstart", function (e) {
        const touch = e.originalEvent.touches[0];
        startX = touch.pageX;
        startY = touch.pageY;
        isDragging = false;
    });

    $(document).on("touchmove", function (e) {
        if (startX === undefined || startY === undefined) return;
        const touch = e.originalEvent.touches[0];
        const dx = touch.pageX - startX;
        const dy = touch.pageY - startY;

        if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
            isDragging = true;
            const $bubble = $("#chat-bubble-ext");
            const offset = $bubble.offset();
            $bubble.offset({
                top: offset.top + dy,
                left: offset.left + dx,
            });
            startX = touch.pageX;
            startY = touch.pageY;
        }
    });

    $(document).on("touchend", function () {
        startX = startY = undefined;
    });

    




    let activeChatId = '';


    $("#minimize-chat").click(function () {
        $("#chat-box-ext").fadeOut(100, function () {
            $("#chat-bubble-ext").fadeIn(100);
        });
    });


    $("#chat-bubble-ext").on("click touchend", function (e) {
        if (isDragging) {
            isDragging = false;
            return; // Jangan buka chat jika baru saja drag
        }

        // Buka chat
        $("#chat-bubble-ext").fadeOut(100, function () {
            $("#chat-box-ext").fadeIn(100);
            loadChatList();
        });
    });

    $("#chat-menu-ext").click(function (event) {
        event.stopPropagation(); // Hindari event bubbling
        let dropdownMenu = $("#chat-menu-ext");
        dropdownMenu.toggleClass("show");
    });

    $(document).click(function (event) {
        if (!$(event.target).closest("#chat-menu-ext, #chat-menu-ext").length) {
            $("#chat-menu-ext").removeClass("show");
        }
    });

    // Tutup chat jika klik di luar chat-box-ext
    $(document).click(function (event) {
        let chatBox = $("#chat-box-ext");
        let chatBubble = $("#chat-bubble-ext");

        // Jika yang diklik bukan chatBox atau isinya, maka tutup chat
        if (!chatBox.is(event.target) && chatBox.has(event.target).length === 0 &&
            !chatBubble.is(event.target) && chatBubble.has(event.target).length === 0) {
            chatBox.fadeOut(100, function () {
                chatBubble.fadeIn(100);
            });
        }
    });




    // Load chat list
    function loadChatList() {
        $.ajax({
            url: "view/ajax/get_chat_list.php",
            type: "POST",
            data: { id_user: "<?= $id_user; ?>" },
            success: function (response) {
                if (response.success) {
                    $("#chat-history").empty().append('<option value="">New Chat</option>');
                    response.data.forEach(chat => {
                        let selected = chat.id_dg_chat_ai_title == activeChatId ? "selected" : "";
                        $("#chat-history").append(`<option value="${chat.id_dg_chat_ai_title}" ${selected}>${chat.title_chat}</option>`);
                    });
                }
            }
        });
    }

    function refreshChatFromServer() {
        activeChatId = $("#chat-history").val();
        $("#chat-content-ext").empty();

        $.ajax({
                url: "view/ajax/get_chat.php",
                type: "POST",
                data: { id_dg_chat_ai_title: activeChatId },
                success: function (response) {
                    if (response.success) {
                        response.data.forEach(chat => {
                        let className = chat.status_chat == 1 ? "user" : "ai";
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


                        $("#chat-content-ext").append(`<div class="chat-message-ext ${className}">${formattedDetail}</div>`);
                        Prism.highlightAll();

                    });

                        scrollToBottom();
                    }
                }
            });
        }
    

    // Load chat history
    $("#chat-history").change(function () {
        activeChatId = $(this).val();
        $("#chat-content-ext").empty();
        if (activeChatId) {
            $.ajax({
                url: "view/ajax/get_chat.php",
                type: "POST",
                data: { id_dg_chat_ai_title: activeChatId },
                success: function (response) {
                    if (response.success) {
                        response.data.forEach(chat => {
                        let className = chat.status_chat == 1 ? "user" : "ai";
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


                        $("#chat-content-ext").append(`<div class="chat-message-ext ${className}">${formattedDetail}</div>`);
                        Prism.highlightAll();

                    });

                        scrollToBottom();
                    }
                }
            });
        }
    });

    // Event submit dengan Enter
    $("#chat-input-ext").keypress(function (event) {
        if (event.which === 13 && !event.shiftKey) {
            event.preventDefault();
            $("#send-chat-ext").click();
        }
    });

    
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


    // Send chat
    $("#send-chat-ext").click(async function () {
        let userMessage = $("#chat-input-ext").val().trim();
        if (userMessage === "") return;

        $("#chat-input-ext").val("").focus();
        scrollToBottom();

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

        if (!activeChatId) {
            // 🔹 Cek nomor terakhir dari "New Chat X"
            let lastChatNumber = 0;
            $("#chat-history option").each(function () {
                let match = $(this).text().match(/New Chat (\d+)/);
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
                    if (response.success) {
                        activeChatId = response.id_dg_chat_ai_title; // 🔹 Simpan ID baru
                        loadChatList(); // 🔹 Perbarui daftar chat
                        saveUserMessage(userMessage);
                    } else {
                        console.error("Gagal membuat chat baru.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error AJAX:", error, xhr.responseText);
                }
            });
        } else {
            saveUserMessage(userMessage);
        }

        
    });


    $(document).on("click", ".rename-chat", function () {
        let chatHistory = $("#chat-history");
        let selectedOption = chatHistory.find("option:selected");
        let chatId = selectedOption.val();
        let oldTitle = selectedOption.text();

        if (!chatId) {
            toastr.warning("New Chat cannot be renamed!");
            return;
        }

        // Buat input field untuk edit judul
        let inputField = $(`<input type="text" class="form-control edit-input" value="${oldTitle}" data-id="${chatId}">`);

        // Ganti select dengan input
        chatHistory.replaceWith(inputField);
        inputField.focus();
        inputField.select(); // Select semua teks dalam input

        function saveRename() {
            let newTitle = inputField.val().trim();
            if (newTitle === "") newTitle = oldTitle;

            $.ajax({
                url: "view/ajax/update_chat.php",
                type: "POST",
                dataType: "json",
                data: { id_dg_chat_ai_title: chatId, title_chat: newTitle },
                success: function (response) {
                    if (response.success) {
                        toastr.success("Chat renamed successfully!");
                        selectedOption.text(newTitle);
                    } else {
                        toastr.error("Failed to rename chat.");
                    }
                    loadChatList();
                },
                complete: function () {
                    restoreSelect(chatHistory, newTitle, chatId);
                }
            });
        }

        // Simpan saat tekan Enter
        inputField.on("keydown", function (e) {
            if (e.key === "Enter") {
                saveRename();
            }
        });

        // Simpan saat klik di luar input
        $(document).on("click.renameOutside", function (event) {
            if (!$(event.target).closest(".edit-input").length) {
                saveRename();
                $(document).off("click.renameOutside"); // Hapus event listener setelah penyimpanan
            }
        });

        function restoreSelect(chatHistory, title, chatId) {
            let newSelect = $(`
                <select id="chat-history" class="chat-history">
                    <option value="${chatId}" selected>${title}</option>
                </select>
            `);
            
            inputField.replaceWith(newSelect);
            rebindChatHistoryEvent(); // Rebind event setelah elemen baru muncul
        }
    });

    // Fungsi untuk mengembalikan event change pada chat-history
    function rebindChatHistoryEvent() {
        $("#chat-history").off("change").on("change", function () {
            activeChatId = $(this).val();
            $("#chat-content-ext").empty();
            if (activeChatId) {
                $.ajax({
                    url: "view/ajax/get_chat.php",
                    type: "POST",
                    data: { id_dg_chat_ai_title: activeChatId },
                    success: function (response) {
                        if (response.success) {
                            response.data.forEach(chat => {
                                let className = chat.status_chat == 1 ? "user" : "ai";
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


                                $("#chat-content-ext").append(`<div class="chat-message-ext ${className}">${formattedDetail}</div>`);
                                Prism.highlightAll();

                            });
                            scrollToBottom();
                        }
                    }
                });
            }
        });
    }



    $(document).on("click", ".delete-chat", function () {
        let chatId = $("#chat-history option:selected").val();
        if (!chatId) {
            toastr.warning("New Chat cannot be deleted!");
            return; // Jika opsi yang dipilih kosong atau "New Chat", hentikan fungsi
        }

        if (confirm("Are you sure you want to delete this chat?")) {
            $.ajax({
                url: "view/ajax/delete_chat.php",
                type: "POST",
                dataType: "json",
                data: { id_dg_chat_ai_title: chatId, id_user: "<?= $id_user; ?>"  },
                success: function (response) {
                    if (response.success) {
                        toastr.success("Chat deleted successfully!");
                        $("#chat-history option:selected").remove();
                        $("#chat-content-ext").empty();
                        $("#chat-input-ext").val("");

                        loadChatList();

                        setTimeout(() => {
                            let firstChat = $("#chat-history option").first();
                            if (firstChat.length > 0) {
                                firstChat.prop("selected", true);
                                $("#chat-history").trigger("change");
                            }
                        }, 100); // Delay 100ms, bisa disesuaikan kalau perlu


                    } else {
                        console.log("response: ", response);
                        
                        toastr.error("Failed to delete chat.");
                    }
                }
            });
        }
    });



    function saveUserMessage(userMessage) {
        $.ajax({
            url: "view/ajax/save_chat.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                id_dg_chat_ai_title: activeChatId,
                status_chat: 1,
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
                        let userBubble = $('<div class="chat-message-ext user"></div>').html(escapedMessage);

                        
                        $("#chat-content-ext").append(userBubble);
                        $("#prompt").val(""); // Kosongkan input
                        $("#chat-content-ext").scrollTop($("#chat-content-ext")[0].scrollHeight);

                        

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
                //$("#chat-content-ext").append(`<div class="chat-message-ext user">${userMessage}</div>`);
                processChat(userMessage);
            }
        });
    }


    function processChat(userMessage) {
        $.ajax({
            url: "view/ajax/get_chat_history.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ id_dg_chat_ai_title: activeChatId }),
            success: function (chatHistoryResponse) {
                let chatHistory = chatHistoryResponse.history || [];
                let chatContext = chatHistory.map(chat => {
                    let role = chat.status == 1 ? "Saya" : "Kamu";
                    return `${role}: ${chat.message}`;
                }).join("\n");

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
                    finalPrompt = `Berikut ini adalah percakapan kita sebelumnya:\n${chatContext}\nBerikut tambahan permintaan dari saya: ${userMessage}\n\n${additionalNote}`;
                } else {
                    finalPrompt = `Berikut permintaan dari saya: ${userMessage}\n\n${additionalNote}`;
                }

                console.log("Final Prompt Sent to API:", finalPrompt);


                // Tampilkan efek mengetik
                let typingIndicator = $('<div class="chat-message-ext ai typing">AI is thinking...</div>');
                $("#chat-content-ext").append(typingIndicator);
                $("#chat-content-ext").scrollTop($("#chat-content-ext")[0].scrollHeight);

                let typingText = "AI is thinking";
                let dotCount = 0;

                let typingAnimation = setInterval(() => {
                    dotCount = (dotCount + 1) % 4;
                    typingIndicator.text(typingText + ".".repeat(dotCount));
                }, 500);

                scrollToBottom();

                let typeData = "mng_ai";

                $.ajax({
                    url: "view/ajax/chat_api.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        prompt: finalPrompt,
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
                                    let lastAiBubble = $("#chat-content-ext .chat-bubble-ext.ai").last();
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


                        
                                    saveAIMessage(aiResponse);


                    }
                });
            }
        });
    }

    function saveAIMessage(aiMessage) {
        $.ajax({
            url: "view/ajax/save_chat.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                id_dg_chat_ai_title: activeChatId,
                status_chat: 2, // 2 = AI Response
                chat_detail: aiMessage
            }),
            success: function (response) {
                loadChatList();

                // Fix: Efek mengetik lebih natural, termasuk tag HTML
                let rawTokens = aiMessage.match(/<[^>]+>|[^<]+/g); // Pisahkan tag dan teks biasa
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

                let aiBubble = $('<div class="chat-message-ext ai"></div>');
                $("#chat-content-ext").append(aiBubble);
                $("#chat-content-ext").scrollTop($("#chat-content-ext")[0].scrollHeight);

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

                    $("#chat-content-ext").scrollTop($("#chat-content-ext")[0].scrollHeight);
                }, 10); // Tetap smooth, tapi muncul 3 huruf tiap 20ms
                
            },
            error: function (xhr, status, error) {
                console.error("Error saat menyimpan AI response:", error);
            }
        });
    }

    function scrollToBottom() {
        $("#chat-content-ext").scrollTop($("#chat-content-ext")[0].scrollHeight);
    }
});

</script>
