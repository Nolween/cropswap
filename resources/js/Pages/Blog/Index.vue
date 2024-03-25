<template>
    <div>
        <navigation-menu></navigation-menu>
        <div class="bg-orange-500 w-full">
            <h1 class="text-9xl text-center text-white font-extrabold font-title py-8">LE BLOG</h1>
        </div>
        <div class="flex flex-wrap w-full bg-orange-500">
            <!-- LAST ARTICLE -->
            <div class="w-full lg:w-1/2 p-3 lg:p-6 space-y-4">
                <img
                    src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="image" class="w-full"/>
                <div class="text-white">
                    <h2 class="text-3xl font-bold">Le titre</h2>
                    <p class="text-xl">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                        publishing industries for previewing layouts and visual mockups.</p>
                </div>
            </div>
            <!-- 3 OTHER ARTICLES -->
            <div class="w-full lg:w-1/2 flex flex-wrap p-3 lg:p-6 space-y-2">
                <div class="h-52 space-x-2 flex">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-1/2 object-cover"/>
                    <div class="text-white w-1/2 p-2">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-md">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
                <div class="h-52 space-x-2 flex">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-1/2 object-cover"/>
                    <div class="text-white w-1/2 p-2">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-md">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
                <div class="h-52 space-x-2 flex">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-1/2 object-cover"/>
                    <div class="text-white w-1/2 p-2">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-md">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- OTHER ARTICLES AND SEARCH -->
        <div class="w-full flex flex-wrap p-6">
            <div class="w-1/2 text-2xl pl-2">Autres Articles</div>
            <div class="w-1/2">
                <input type="text" placeholder="Rechercher un article" class="w-full p-2"/>
            </div>
        </div>


        <!-- OTHER ARTICLES IN GRID -->
        <div class="w-full p-3 lg:p-6 space-y-4 mb-40">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="space-y-2 p-2">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-full object-cover"/>
                    <div class="text-black">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-xl">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
                <div class="space-y-2 p-2">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-full object-cover"/>
                    <div class="text-black">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-xl">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
                <div class="space-y-2 p-2">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-full object-cover"/>
                    <div class="text-black">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-xl">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
                <div class="space-y-2 p-2">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-full object-cover"/>
                    <div class="text-black">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-xl">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
                <div class="space-y-2 p-2">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-full object-cover"/>
                    <div class="text-black">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-xl">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
                <div class="space-y-2 p-2">
                    <img
                        src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="w-full object-cover"/>
                    <div class="text-black">
                        <h2 class="text-3xl font-bold">Le titre</h2>
                        <p class="text-xl">Lorem ipsum is placeholder text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder
                            text commonly used in the graphic, print, and
                            publishing industries for previewing layouts and visual mockups.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import NavigationMenu from '@/Layouts/NavigationMenu.vue';

</script>
<style scoped>

</style>
