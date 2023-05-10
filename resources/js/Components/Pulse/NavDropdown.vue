<template>
    <Menu as="div" class="z-10 relative inline-block text-left content-evenly">
        <div class="px-1 py-2 flex items-baseline">
            <!--main navigation-->
            <MenuButton class="text-gray-400 px-3 py-2 rounded-md  uppercase tracking-[4px] font-bold hover:text-gray-300 hover:bg-gray-700">
                {{ title }}
            </MenuButton>
        </div>
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="origin-top-left absolute left-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                <div class="py-4">
                    <slot></slot>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
const daily = [
    { name: "Deals Priced Today", href: "#" },
    { name: "Additional Deals Priced Today", href: "#" },
    { name: "Expected Tonight", href: "#" }
]
export default {
    name: "NavDropdown",
    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
    },
    props: {
        title: String
    }
}
</script>

<style scoped>

</style>
