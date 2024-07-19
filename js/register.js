import { validateEmail, isLoggedIn } from './utils.js'

$(document).ready(() => {
  isLoggedIn().then(value => {
    if (value) {
      return window.location.replace('./index.html')
    }
  })

  $('#register-form').on('submit', e => {
    e.preventDefault()
    $('.error-message').html('')

    const email = $('#register-form-email').first().val()
    const password = $('#register-form-password').first().val()
    const repassword = $('#register-form-repassword').first().val()

    if (!validateEmail(email)) {
      return $('.error-message').html('Nieprawidłowy adres email')
    }

    if (password !== repassword) {
      return $('.error-message').html('Hasła muszą być takie same')
    }

    if (password.length < 8) {
      return $('.error-message').html('Hasło powinno zawierać przynajmniej 8 znaków')
    }

    $.ajax({
      url: './php/register.php',
      type: 'POST',
      data: JSON.stringify({ email, password, repassword }),
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
