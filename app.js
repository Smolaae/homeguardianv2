// Language Management
let currentLanguage = "fr"
let translations = {}

// Load translations
async function loadTranslations(lang) {
  try {
    const response = await fetch(`locales/${lang}.json`)
    translations = await response.json()
    updatePageContent()
  } catch (error) {
    console.error("Error loading translations:", error)
  }
}

// Update page content with translations
function updatePageContent() {
  document.querySelectorAll("[data-i18n]").forEach((element) => {
    const keys = element.getAttribute("data-i18n").split(".")
    let value = translations

    for (const key of keys) {
      value = value[key]
      if (!value) break
    }

    if (value) {
      if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
        element.placeholder = value
      } else {
        element.textContent = value
      }
    }
  })

  // Update testimonials
  updateTestimonials()
}

// Change language
function changeLanguage(lang) {
  currentLanguage = lang
  document.documentElement.lang = lang
  loadTranslations(lang)
}

// Update testimonials dynamically
function updateTestimonials() {
  const container = document.getElementById("testimonials-container")
  if (!container || !translations.testimonials) return

  container.innerHTML = ""

  translations.testimonials.reviews.forEach((review, index) => {
    const card = document.createElement("div")
    card.className = "bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg fade-in"
    card.style.animationDelay = `${index * 0.1}s`

    const stars = "★".repeat(review.rating) + "☆".repeat(5 - review.rating)

    card.innerHTML = `
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center text-2xl font-bold text-blue-500">
                    ${review.name.charAt(0)}
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white">${review.name}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">${review.role}</p>
                </div>
            </div>
            <div class="text-yellow-400 text-xl mb-4">${stars}</div>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">${review.text}</p>
        `

    container.appendChild(card)
  })
}

// Dark Mode Toggle
const darkModeToggle = document.getElementById("darkModeToggle")
const html = document.documentElement

// Check for saved dark mode preference
const savedDarkMode = localStorage.getItem("darkMode")
if (savedDarkMode === "enabled") {
  html.classList.add("dark")
  document.body.classList.add("dark-mode")
}

darkModeToggle.addEventListener("click", () => {
  const isDarkMode = html.classList.toggle("dark")
  document.body.classList.toggle("dark-mode")

  if (isDarkMode) {
    localStorage.setItem("darkMode", "enabled")
  } else {
    localStorage.setItem("darkMode", "disabled")
  }
})

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault()
    const target = document.querySelector(this.getAttribute("href"))
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      })
    }
  })
})

// Scroll Animations
const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -50px 0px",
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("visible")
    }
  })
}, observerOptions)

document.querySelectorAll(".fade-in").forEach((el) => {
  observer.observe(el)
})

// Contact Form Handling
const contactForm = document.getElementById("contactForm")
const formMessage = document.getElementById("formMessage")

contactForm.addEventListener("submit", async (e) => {
  e.preventDefault()

  const submitButton = contactForm.querySelector('button[type="submit"]')
  const originalText = submitButton.textContent

  // Get form data
  const formData = {
    name: document.getElementById("name").value,
    email: document.getElementById("email").value,
    subject: document.getElementById("subject").value,
    message: document.getElementById("message").value,
  }

  // Update button state
  submitButton.textContent = translations.contact.form.sending
  submitButton.disabled = true

  // Simulate form submission (replace with actual API call)
  try {
    await new Promise((resolve) => setTimeout(resolve, 1500))

    // Show success message
    formMessage.textContent = translations.contact.form.success
    formMessage.className = "mt-4 text-center text-green-600 dark:text-green-400 font-semibold"
    formMessage.classList.remove("hidden")

    // Reset form
    contactForm.reset()

    // Hide message after 5 seconds
    setTimeout(() => {
      formMessage.classList.add("hidden")
    }, 5000)
  } catch (error) {
    // Show error message
    formMessage.textContent = translations.contact.form.error
    formMessage.className = "mt-4 text-center text-red-600 dark:text-red-400 font-semibold"
    formMessage.classList.remove("hidden")
  } finally {
    // Reset button state
    submitButton.textContent = originalText
    submitButton.disabled = false
  }
})

// Video Thumbnail Click Handler
document.querySelectorAll(".video-thumbnail").forEach((thumbnail) => {
  thumbnail.addEventListener("click", () => {
    alert("Video player would open here. Integrate with your preferred video platform (YouTube, Vimeo, etc.)")
  })
})

// Navbar scroll effect
let lastScroll = 0
const navbar = document.querySelector("nav")

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset

  if (currentScroll > 100) {
    navbar.style.boxShadow = "0 4px 6px -1px rgba(0, 0, 0, 0.1)"
  } else {
    navbar.style.boxShadow = "0 1px 3px 0 rgba(0, 0, 0, 0.1)"
  }

  lastScroll = currentScroll
})

// Initialize
loadTranslations(currentLanguage)
