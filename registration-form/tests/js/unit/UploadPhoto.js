import UploadPhotoInput from '../../../resources/js/components/UploadPhotoInput.vue'
import { mount } from '@vue/test-utils'

describe('upload photo', () => {
  let wrapper
  let form
  beforeEach(function () {
    form = {
      photo: null,
      errors: {},
      setError: jest.fn(function (field, message) {
        this.errors[field] = message
      }),
      clearErrors: jest.fn(function (field) {
        delete this.errors[field]
      }),
    }

    wrapper = mount(UploadPhotoInput, {
      props: { form }
    })
  })

  it('should set error when photo exceeds the size limit', async () => {

    const photo = new File(
      [new Uint8Array(4000 * 1024)],
      'photo.webp',
      { type: 'image/webp' },
    )

    const photoInput = wrapper.find('input[name="photo"]')

    Object.defineProperty(photoInput.element, 'files', {
      value: [photo],
    })

    await photoInput.trigger('change')

    expect(form.setError).toHaveBeenCalledWith(
      'photo',
      'The photo field must not be greater than 3024 kilobytes.',
    )
  })

  it('should cancel photo', async () => {
    const photo = new File(
      [new Uint8Array(3072 * 1024)],
      'photo.webp',
      { type: 'image/webp' },
    )

    const photoInput = wrapper.find('input[name="photo"]')

    Object.defineProperty(photoInput.element, 'files', {
      value: [photo],
    })
    await photoInput.trigger('change')
    await wrapper.find('#cancel-selected-photo-btn').trigger('click')

    expect(form.photo).toBeNull()
    expect(photoInput.element.value).toBe('')
  })
})