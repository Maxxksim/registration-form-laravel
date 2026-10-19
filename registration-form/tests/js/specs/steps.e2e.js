import stepOnePage from '../pageobjects/StepOne.page.js'
import stepTwoPage from '../pageobjects/StepTwo.page.js'
import { fileURLToPath } from 'node:url'
import path from 'node:path'
import { faker } from '@faker-js/faker'

describe('passing steps', () => {
  it('should pass step one with valid data', async () => {
    await stepOnePage.open()

    await stepOnePage.firstName.setValue('Test First Name')
    await stepOnePage.lastName.setValue('Test Last Name')
    await stepOnePage.selectBirthdate()
    await stepOnePage.reportSubject.setValue('Test Report Subject')
    await stepOnePage.selectCountry('Ukraine')
    await stepOnePage.selectCountryCode('ua')
    await stepOnePage.phone.setValue('677067131')
    await stepOnePage.email.setValue(faker.internet.email())

    await stepOnePage.submitForm()

    await expect(browser).toHaveUrl('http://127.0.0.1:8000/register/steps/two')
  })

  it('should pass step two with valid data', async () => {
    await stepTwoPage.open()

    await stepTwoPage.company.setValue('Test Company')
    await stepTwoPage.position.setValue('Test Position')
    await stepTwoPage.aboutMe.setValue('Test About Me')
    const photoPath = path.join(path.dirname(fileURLToPath(import.meta.url)), '../../TestFiles/testphoto.webp')
    await stepTwoPage.photo.setValue(photoPath)

    await stepTwoPage.submitForm()

    await expect(browser).toHaveUrl('http://127.0.0.1:8000/register/steps/thanks')
  })
})

