<script>
     $("#chat-form").submit(function (e) {
                e.preventDefault();

                let fileInput = $("#file-upload")[0];
                let file = fileInput.files[0];
                let hasFile = file !== undefined;


                let userMessage = $("#prompt").val().trim();
                if (userMessage === "") return;

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
                let newChat = $(".chat-list-item[data-id='30']");
                

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


                        let escapedMessage = escapeHtml(userMessage).replace(/\n/g, "<br>");
                        let userBubble = $('<div class="chat-bubble user"></div>').html(escapedMessage);
                        $("#chat-box").append(userBubble);
                        $("#prompt").val(""); // Kosongkan input
                        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);

                        // Tampilkan efek mengetik
                        let typingIndicator = $('<div class="chat-bubble ai typing">AI is thinking...</div>');
                        $("#chat-box").append(typingIndicator);
                        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                        

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

                                let additionalNote = "Notes: Jika ada permintaan gambar maka gunakan format ini untuk semua gambarnya ![IMG][promt dalam bahasa inggris]. Jika tidak, tidak perlu dibuat."
                                                     + "Sisipkan spasi / enter setelah dan sebelum ![IMG][prompt]."
                                                     + "Contoh: <spasi> ![IMG][a cat with a hat] <spasi>."
                                                     + "Kamu bisa membuat gambar jumlahnya sesuai yang di minta, jika diminta 1 buatkan 1. Jika tidak ada jumlahnya kamu atur sendiri jumlahnya gambarnya." 
                                                     + "Jangan lupa memberikan penjelasan tambahan tentang gambar tersebut."
                                                     + "Berikan jawaban menggunakan bahasa yang kamu cek dari permintaan atau percakapan user terakhir.";
                                                    
                                                     
                                                     
                                                    

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

                            // Kirim permintaan ke chat_api.php
                            $.ajax({
                                url: "view/ajax/chat_api.php",
                                type: "POST",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    prompt: finalPrompt,
                                    ai_type: aiType,
                                    upscale: upscale,
                                    aspect_ratio: aspectRatio
                                }),

                                success: function (response) {
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

                                    // Jika jawaban kosong, tampilkan error
                                    if (!aiResponse.trim()) {
                                        aiResponse = "Error : No valid response from AI.";
                                    }

                                    // 🔥 **Fix: Cek duplikasi secara lebih ketat**
                                    let lastAiBubble = $("#chat-box .chat-bubble.ai").last();
                                    if (lastAiBubble.length > 0 && lastAiBubble.html().trim() === aiResponse.trim()) {
                                        return; // Jangan tampilkan jika jawaban terakhir sama persis
                                    }
       

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
                                            // 🛠 **Fix 2: Efek mengetik lebih natural**
                                            let tokens = aiResponse.split(/(<br\s*\/?>|<\/?strong>)/gi);

                                            let aiBubble = $('<div class="chat-bubble ai"></div>');
                                            $("#chat-box").append(aiBubble);
                                            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);

                                            let index = 0;
                                            let typingEffect = setInterval(function () {
                                                if (index < tokens.length) {
                                                    if (tokens[index] === "<strong>") {
                                                        aiBubble.append('<strong>'); // Mulai teks bold
                                                    } else if (tokens[index] === "</strong>") {
                                                        aiBubble.append('</strong>'); // Tutup teks bold
                                                    } else if (tokens[index] === "<br>") {
                                                        aiBubble.append('<br>'); // Tambahkan enter yang sudah diperbaiki
                                                    } else {
                                                        let lastElem = aiBubble.children("strong").last();
                                                        if (lastElem.length > 0 && lastElem.text() === "") {
                                                            lastElem.append(tokens[index]); // Tambahkan teks ke dalam <strong> jika aktif
                                                        } else {
                                                            aiBubble.append(tokens[index]); // Tambahkan teks biasa
                                                        }
                                                    }
                                                    index++;
                                                    
                                                } else {
                                                    clearInterval(typingEffect);
                                                    refreshChatFromServer(); // ⬅️ Tambahkan ini
                                                }
                                                $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                                            }, 20);
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