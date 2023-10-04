export function toDate(timestamp) {
    if (typeof timestamp === 'number') {
        timestamp *= 1000
    }

    return new Date(timestamp).toLocaleDateString('ru-RU', {
        minute: 'numeric',
        hour: 'numeric',
        year: "numeric",
        month: "long",
    })
}
