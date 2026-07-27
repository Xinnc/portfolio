export function getYoutubeEmbedUrl(url) {
    if (!url) return null

    const short = url.match('/youtu\.be\/([^?]+)/')
    if (short) {
        return `https://www.youtube.com/embed/${short[1]}`;
    }

    const watch = url.match(/[?&]v=([^&]+)/);
    if (watch) {
        return `https://www.youtube.com/embed/${watch[1]}`;
    }

    if (url.includes('/embed/')) {
        return url;
    }

    return null;
}