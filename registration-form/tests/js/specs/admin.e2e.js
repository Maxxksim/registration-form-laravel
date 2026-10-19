import adminAuthPage from '../pageobjects/AdminAuth.page.js'
import adminPanelPage from '../pageobjects/AdminPanel.page.js'
import axios from 'axios'

describe('admin opportunities', () => {
  let member

  beforeAll(async function () {
    const { data } = await axios.get(`${browser.options.baseUrl}/test/members/generate`,
      {
        headers: { Accept: 'application/json' }
      })

    member = data.memberData
  })

  it('admin should log in to admin panel with valid credentials', async function () {
    await adminAuthPage.open()

    await adminAuthPage.username.setValue('admin')
    await adminAuthPage.password.setValue('admin')
    await adminAuthPage.submitForm()

    await expect(browser).toHaveUrl('http://127.0.0.1:8000/admin/panel')
  })

  it('admin should edit member data', async function () {
    const memberId = member.id
    await adminPanelPage.open()

    await adminPanelPage.edit(memberId)
    await expect(adminPanelPage.editMemberForm).toBeDisplayed()

    await $('input[name="company"]').setValue('Test Company')
    await $('input[name="position"]').setValue('Test Position')
    await $('textarea[name="about_me"]').setValue('Test About Me')
    await adminPanelPage.update(memberId)
    await expect(adminPanelPage.editMemberForm).not.toExist()

    const company = $(`#company-${memberId}`)
    const position = $(`#position-${memberId}`)
    const aboutMe = $(`#about-me-${memberId}`)

    await expect(company).toHaveText('Test Company')
    await expect(position).toHaveText('Test Position')
    await expect(aboutMe).toHaveText('Test About Me')
  })

  it('admin should switch visibility member', async function () {
    const memberId = member.id
    await adminPanelPage.open()

    const currentVisibility = await adminPanelPage.getMemberVisibilityStatus(memberId).getText()
    const expectedVisibility = currentVisibility === 'VISIBLE' ? 'HIDDEN' : 'VISIBLE'
    await adminPanelPage.switchVisibility(memberId)

    await expect(adminPanelPage.getMemberVisibilityStatus(memberId))
      .toHaveText(expectedVisibility)
  })

  it('admin should delete member', async function () {
    const memberId = member.id
    await adminPanelPage.open()

    await adminPanelPage.delete(memberId)
    await adminPanelPage.getBtnToConfirmDeletingMember(memberId).waitForDisplayed()
    await adminPanelPage.confirmDeleting(memberId)
    await expect(adminPanelPage.getMemberCard(memberId)).not.toExist()
  })
})