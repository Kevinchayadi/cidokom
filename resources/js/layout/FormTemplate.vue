<template>
    <div :class="[templatestyle]">
        <div :class="formBox">
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
    const templatestyle = "min-h-screen w-full flex items-center p-xl justify-center bg-primary-dark"
    const backgroundstyle = "backcustom"
    const formBox = 'w-[80%] md:w-[60%] md:min-h-[200px] my-10 glassBackground rounded-xl flex items-center justify-center p-4 md:p-8'

</script>
<style>


.glassBackground{
    background: rgba(164, 164, 164, 0.537);
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.312);
    
}
    
</style>