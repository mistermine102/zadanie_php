export const validateEmail = email => {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    )
}

export const isLoggedIn = () => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: './php/login.php',
      type: 'GET',
      success: (res) => {
        resolve(res.isAuth)
      },
      error: (res) => {
        reject(res)
      },
    })
  })
}
