<div class="hidden">

</div>
<div class="mb-4">
    <div class="mr-4 inline-block w-full max-w-xs">
        <x-color-input
            label="Accent (Light)"
            color-class="bg-accent-light"
            :value="$colors['bg-accent-light']"
            id="colors-accent-light"
            name="colors[accent][light]"
        />
        <x-color-input
            label="Accent (Medium)"
            color-class="bg-accent-medium"
            :value="$colors['bg-accent-medium']"
            id="colors-accent-medium"
            name="colors[accent][medium]"
        />
        <x-color-input
            label="Accent (Dark)"
            color-class="bg-accent-dark"
            :value="$colors['bg-accent-dark']"
            id="colors-accent-dark"
            name="colors[accent][dark]"
        />
    </div>
    <div class="inline-block w-full max-w-xs">
        <x-color-input
            label="Base (Light)"
            color-class="bg-base-light"
            :value="$colors['bg-base-light']"
            id="colors-base-light"
            name="colors[base][light]"
        />
        <x-color-input
            label="Base (Medium)"
            color-class="bg-base-medium"
            :value="$colors['bg-base-medium']"
            id="colors-base-medium"
            name="colors[base][medium]"
        />
        <x-color-input
            label="Base (Dark)"
            color-class="bg-base-dark"
            :value="$colors['bg-base-dark']"
            id="colors-base-dark"
            name="colors[base][dark]"
        />
    </div>

</div>
