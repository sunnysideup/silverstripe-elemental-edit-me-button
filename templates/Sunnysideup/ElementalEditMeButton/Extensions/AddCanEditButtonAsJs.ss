<%-- keep space here --%>
template = `
    <div style="
        z-index: 9999;
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
    " class="edit-me-button">
        <a
            href="/admin/pages/edit/EditForm/$ID/field/ElementalArea/item/[ID-GOES-HERE]/edit"
            title="Edit in CMS"
            style="
                 display: block;
                 text-decoration: none;
                 width: 100%;
                 height: 100%;
                 text-decoration: none;
                 border-bottom: none;"
        >
            <span
                style="
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    -webkit-transform: translate(-50%,-50%);
                    transform: translate(-50%,-50%);
                    -ms-transform: translate(-50%,-50%);
                    color: #333;
            ">✎</span>
        </a>
    </div>
`

let i;
for (i = 0; i < ElementalEditMeButtonIds.length; i++) {
  const urlSegment = ElementalEditMeButtonIds[i];
  let elem = document.querySelector ( '#' + urlSegment );
  if(elem) {
    elem.style.position = 'relative';
    const templateForMe = template.replace('[ID-GOES-HERE]', id);
    elem.innerHTML = templateForMe + elem.innerHTML;
  }
}
