```html
<section
	<% if $canEdit %>style="position: relative"<% end_if %>
	id="$Anchor"
	class="
		element panel panel--$Colour $BlockHeadingColour
		$getSimpleClassNameSimpler.LowerCase
		<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>"
>
	$Element
<% if $canEdit %>
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
    ">
        <a
            href="$CMSEditLink"
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

<% end_if %>
</section>
```
