import Page from './page.js'

class StepTwoPage extends Page {
  get company () {
    return $('input[name="company"]')
  }

  get position () {
    return $('input[name="position"]')
  }

  get aboutMe() {
    return $('textarea[name="about_me"]')
  }

  get photo() {
    return $('input[name="photo"]')
  }

  get finishBtn() {
    return $('#step-two-btn');
  }

  async submitForm() {
    await this.finishBtn.click()
  }

  async open() {
    await super.open('/register/steps/two')
  }
}

export default new StepTwoPage()