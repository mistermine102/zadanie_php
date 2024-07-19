$(document).ready(() => {
  $('#logout-btn').click(logout)
  getUser()
})

function getUser() {
  $.ajax({
    method: 'GET',
    url: './php/login.php',
    success: res => {
      if (!res.isAuth) {
        return $('#welcome-container').css('display', 'none')
      }
      $('#login-container').css('display', 'none')

      const { id, email } = res.user

      $('#user-email').html(email)
      $('#user-id').html(id)
    },
    error: res => {
      console.log(res)
    },
  })
}

function logout() {
  $.ajax({
    method: 'POST',
    url: './php/logout.php',
    success: () => {
      $('#welcome-container').css('display', 'none')
      $('#login-container').css('display', 'block')
    },
    error: res => {
      console.log(res)
    },
  })
}
