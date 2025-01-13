<%-- keep space here --%>

;(function () {
  const template = `
    <div class="edit-me-button">
        <a
            href="/admin/pages/edit/EditForm/$ID/field/ElementalArea/item/[ID-GOES-HERE]/edit"
            title="Edit in CMS"
        >
            <span>✎</span>
        </a>
    </div>
`
  const applyTemplateToElements = function (
    ElementalEditMeButtonIds,
    template
  ) {
    for (const id in ElementalEditMeButtonIds) {
      const key = ElementalEditMeButtonIds[id]
      let elem = document.querySelector('#' + key)
      if (elem) {
        elem.style.position = 'relative'
        const templateForMe = template.replace('[ID-GOES-HERE]', id)
        elem.innerHTML = templateForMe + elem.innerHTML
      }
    }
  }

  // Function to separate buttons if their parent height is less than 50px
  const handleOverlappingButtons = function () {
    const size = 60
    // Select all buttons with the class "edit-me-button"
    const allButtons = Array.from(document.querySelectorAll('.edit-me-button'))
    // Filter buttons where the parent's height is less than 50px
    const overlappingButtons = allButtons.filter(button => {
      const parentDiv = button.parentElement
      return parentDiv && parentDiv.offsetHeight < size
    })

    // Add event listeners to filtered buttons
    overlappingButtons.forEach(button => {
      button.addEventListener('mouseenter', () => {
        let count = 0
        if(button.classList.contains('out-of-the-way')) {
          return
        }
        allButtons.forEach((otherButton, index) => {
          if (
            otherButton === button ||
            !doButtonsOverlap(button, otherButton)
          ) {
            // Skip the hovered button or buttons that don't overlap
            otherButton.style.marginTop = ``
            otherButton.classList.remove('out-of-the-way')
            return
          }
          count++
          const offsetY = size * count
          otherButton.style.marginTop = `${offsetY}px` // Apply dynamic margin-top
          otherButton.classList.add('out-of-the-way')
        })
      })

      let resetTimeoutId

      button.addEventListener('mouseleave', () => {
        // Clear the previous timeout if it exists
        if (resetTimeoutId) {
          clearTimeout(resetTimeoutId)
        }

        // Set a new timeout to reset buttons after 1 second
        resetTimeoutId = window.setTimeout(() => {
          allButtons.forEach(otherButton => {
            otherButton.style.marginTop = ''
            otherButton.classList.remove('out-of-the-way')
          })

          // Clear the timeout ID after execution
          resetTimeoutId = null
        }, 1000)
      })
    })
  }

  // Function to check if two buttons overlap
  const doButtonsOverlap = function (button1, button2) {
    const rect1 = button1.getBoundingClientRect()
    const rect2 = button2.getBoundingClientRect()

    return !(
      rect1.right < rect2.left ||
      rect1.left > rect2.right ||
      rect1.bottom < rect2.top ||
      rect1.top > rect2.bottom
    )
  }

  applyTemplateToElements(ElementalEditMeButtonIds, template)

  handleOverlappingButtons()
})()

<%-- keep space here --%>
