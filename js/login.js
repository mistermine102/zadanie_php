import { validateEmail, isLoggedIn } from './utils.js'

$(document).ready(() => {
  isLoggedIn().then(value => {
    if (value) {
      return window.location.replace('./index.html')
    }
  })

  $('#login-form').on('submit', e => {
    e.preventDefault()

    const email = $('#login-form-email').first().val()
    const password = $('#login-form-password').first().val()

    if (!validateEmail(email)) {
      return $('.error-message').html('Nieprawidłowy adres email')
    }

    if (password.length < 8) {
      return $('.error-message').html('Hasło powinno zawierać przynajmniej 8 znaków')
    }

    $.ajax({
      url: './php/login.php',
      type: 'POST',
      data: JSON.stringify({ email, password }),
      headers: {
        'Content-Type': 'application/json',
      },
      success: () => {
        window.location.replace('./index.html')
      },
      error: err => {
        $('.error-message').html(err.responseJSON.message)
      },
    })
  })
})
