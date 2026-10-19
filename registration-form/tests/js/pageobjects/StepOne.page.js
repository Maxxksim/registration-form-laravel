import Page from './page.js'

class StepOnePage extends Page {
  get firstName () {
    return $('input[name="first_name"]')
  }

  get lastName () {
    return $('input[name="last_name"]')
  }

  get birthdatePicker () {
    return $('input[name="birthdate"]')
  }

  birthdateOption() {
    return $('.flatpickr-calendar.open .today')
  }

  async selectBirthdate() {
    await this.birthdatePicker.click()
    await this.birthdateOption().click()
  }

  get reportSubject () {
    return $('input[name="report_subject"]')
  }

  get country () {
    return $('select[name="country"]')
  }

  async selectCountry (country) {
    await this.country.selectByAttribute('value', country)
  }

  get countryCodes () {
    return $('.iti__selected-country')
  }

  countryOption (alpha2Code) {
    return $(`.iti__country[data-iso2=${alpha2Code}]`)
  }

  async selectCountryCode (alpha2Code) {
    await this.countryCodes.click()
    await this.countryOption(alpha2Code).click()
  }

  get phone () {
    return $('input[name="phone"]')
  }

  get email() {
    return $('input[name="email"]')
  }

  get nextBtn() {
    return $('#step-one-btn');
  }

  async submitForm() {
    await this.nextBtn.click()
  }

  async open() {
    await super.open('/register/steps/one')
  }
}

export default new StepOnePage()