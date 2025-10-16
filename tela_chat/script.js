document.addEventListener("DOMContentLoaded", () => {
    const communityContainer = document.querySelector('.chat-menssage');
    const chatTitle = document.getElementById('chat-title');
    const chatMessages = document.getElementById('chat-messages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    let selectedCommunityId = null;

    function loadMessages(communityId){
        fetch(`load_messages.php?community=${communityId}`)
            .then(res => res.text())
            .then(html => {
                chatMessages.innerHTML = html;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    communityContainer.addEventListener('click', e => {
        const card = e.target.closest('.card');
        if(!card) return;

        communityContainer.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        selectedCommunityId = card.getAttribute('data-comunidade');
        chatTitle.innerText = card.querySelector('.nameChat').innerText;
        loadMessages(selectedCommunityId);
    });

    sendBtn.addEventListener('click', () => {
        if(!selectedCommunityId) return alert("Selecione uma comunidade primeiro!");
        const message = messageInput.value.trim();
        if(message === '') return;

        fetch('send_message.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `communityId=${selectedCommunityId}&message=${encodeURIComponent(message)}`
        })
        .then(res => res.text())
        .then(res => {
            if(res === 'ok'){
                const div = document.createElement('div');
                div.classList.add('message','sent');
                div.innerHTML = `<div class="bubble-content"><p>${message}</p><span class="time">${new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</span></div>`;
                chatMessages.appendChild(div);
                messageInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                alert(res);
            }
        });
    });
});