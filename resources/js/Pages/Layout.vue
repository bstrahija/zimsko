<template>
    <div>
        <slot />

        <teleport to="body">
            <modals-container></modals-container>
        </teleport>
    </div>
</template>
