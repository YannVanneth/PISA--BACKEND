import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

export function initializeUserComments(recipeId) {
    // Subscribe to the user comments channel
    window.Echo.channel(`user-comments.${recipeId}`)
        .listen('NewUserComment', (event) => {
            // Handle new comment
            const comment = event.comment;
            appendComment(comment);
        });
}

function appendComment(comment) {
    const commentsContainer = document.querySelector('.user-comments-container');
    if (!commentsContainer) return;

    const commentElement = createCommentElement(comment);
    commentsContainer.insertBefore(commentElement, commentsContainer.firstChild);
}

function createCommentElement(comment) {
    const div = document.createElement('div');
    div.className = 'user-comment-item';
    div.setAttribute('data-comment-id', comment.id);
    
    div.innerHTML = `
        <div class="comment-header">
            <img src="${comment.user.avatar}" alt="${comment.user.name}" class="user-avatar">
            <span class="user-name">${comment.user.name}</span>
            <span class="comment-time">${formatDate(comment.created_at)}</span>
        </div>
        <div class="comment-content">
            ${comment.content}
        </div>
    `;

    return div;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(date);
} 