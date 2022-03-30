/* Javascript effet sur scroll */
const ratio = .8 /* ratio = % page affichée avant effet */
const options = {
    root: null,
    rootMargin: '0px',
    threshold: ratio
}

const handleIntersect = function (entries, observer) {
    entries.forEach(function (entry) {
        if (entry.intersectionRatio > ratio) {
            entry.target.classList.remove('reveal')
            observer.unobserve(entry.target)
        }
    })
}

document.documentElement.classList.add('reveal-loaded')
window.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver(handleIntersect, options)
    document.querySelectorAll('.reveal').forEach(function (r) {
        observer.observe(r)
    })
})

/* Crédit Françis DRAILLARD */