import { ref } from "vue"

function initTheme() {
    const savedTheme = localStorage.getItem("theme")

    if (savedTheme) {
        return savedTheme
    }

    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        return "dark"
    }

    return "light"
}

export function useTheme() {
    const theme = ref(initTheme())

    const setTheme = (newTheme) => {
        theme.value = newTheme
        localStorage.setItem("theme", newTheme)
        if (newTheme === "dark") {
            document.documentElement.classList.add("p-dark")
        } else {
            document.documentElement.classList.remove("p-dark")
        }
    }

    setTheme(theme.value)

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem("theme")) {
            setTheme(e.matches ? "dark" : "light")
        }
    })

    return { theme, setTheme }
}