import Page from './page.js'

class AdminAuthPage extends Page {
  get username () {
    return $('input[name="username"]')
  }

  get password () {
    return $('input[name="password"]')
  }

  get loginBtn () {
    return $('#admin-login-btn')
  }

  async submitForm () {
    await this.loginBtn.click()
  }

  async open () {
    await super.open('/admin/login')
  }

}

export default new AdminAuthPage()