<%-- keep space here --%>

window.addEventListener(
    'load',
    () => {
        (function () {
        const template = `
            <div class="edit-me-button">
                <a
                    href="/admin/pages/edit/EditForm/$ID/field/ElementalArea/item/[ID-GOES-HERE]/edit"
                    title="Edit in CMS"
                    target="_parent"
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
            const minHeight = 80
            // Select all buttons with the class "edit-me-button"
            const allButtons = Array.from(document.querySelectorAll('.edit-me-button'))
            // Filter buttons where the parent's height is less than 50px
            const overlappingButtons = allButtons.filter(button => {
            const parentDiv = button.parentElement
            return parentDiv && parentDiv.offsetHeight < minHeight
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
                const offsetY = minHeight * count
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
    }
);

<style>


.edit-me-button {
    transition: all 0.3s;
    z-index: 1;
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #f3f4ee;
    height: 45px;
    width: 45px;
    border-radius: 50px;
    border: 1px solid #ccc;
    -webkit-transform: rotateY(180deg);
    transform: rotateY(180deg);
}
.edit-me-button a {
    display: block;
    text-decoration: none;
    width: 100%;
    height: 100%;
    text-decoration: none;
    border-bottom: none;
}
.edit-me-button a span {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    color: #333;
}
.edit-me-button a:hover span {
    color: green!important;
}
.edit-me-button.hovered {
    z-index: 9999;
}
</style

<%-- keep space here --%>
