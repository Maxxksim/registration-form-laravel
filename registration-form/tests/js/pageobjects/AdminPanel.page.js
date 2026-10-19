import Page from './page.js'

class AdminPanelPage extends Page {
  getBtnToEditMember (id) {
    return $(`[dusk="edit-member-${id}"]`)
  }

  getBtnTuUpdateMember (id) {
    return $(`[dusk="update-member-${id}"]`)
  }

  getBtnToDeleteMember (id) {
    return $(`[dusk="delete-member-${id}"]`)
  }

  getBtnToConfirmDeletingMember (id) {
    return $(`[dusk="confirm-delete-member-${id}"]`)
  }

  getBtnToSwitchVisibilityMember (id) {
    return $(`[dusk="switch-visibility-member-${id}"]`)
  }

  getMemberVisibilityStatus (id) {
    return $(`[dusk="v-s-m-${id}"]`)
  }

  getMemberCard (id) {
    return $(`[dusk="card-member-${id}"]`)
  }

  async edit (id) {
    await this.getBtnToEditMember(id).click()
  }

  async update (id) {
    await this.getBtnTuUpdateMember(id).click()
  }

  async delete (id) {
    await this.getBtnToDeleteMember(id).click()
  }

  async confirmDeleting (id) {
    await this.getBtnToConfirmDeletingMember(id).click()
  }

  async switchVisibility (id) {
    await this.getBtnToSwitchVisibilityMember(id).click()
  }

  async open () {
    await super.open('/admin/panel')
  }

  get editMemberForm () {
    return $('#form-edit-member')
  }
}

export default new AdminPanelPage()