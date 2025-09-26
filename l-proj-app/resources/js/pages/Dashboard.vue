<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Витрина',
        href: dashboard().url,
    },
];

const items = ref([]);

    const fetchData = async () => {
      try {
        const response = await axios.get('/item-data');
        items.value = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    };

var addToCart = async (id) => {
      try {
        const response = await axios.post('/cart-add', {
          item_id: id,
        });
        console.log(response.data);
      } catch (error) {
        console.error('Error sending data:', error);
      }
    };

onMounted(() => {
  fetchData();
});
</script>

<template>
    <Head title="Магазин" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div v-for="item in items" :key="item.id">
                    <div class="relative min-h-[50vh] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <img :src="('./assets/items/'+item.name+'.jpg')">
                        <!--<img :src="getImageUrl(item.name)">{{ item.description }} user.id-->
                        <div class="grid auto-rows-min gap-4 md:grid-cols-4 place-items-center">
                            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A] col-span-4 justify-self-start self-center">
                                {{ item.description }}
                            </p>
                            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A] col-span-2 justify-self-start self-center">
                                {{ item.price / 100 }},{{ item.price % 100 }}р
                            </p>
                            <Button variant="ghost" size = "default" @click="addToCart(item.id)"
                              class="text-[#706f6c] hover:text-[#ff6f6c] dark:text-[#A1A09A] dark:hover:text-[#11ff6c] col-span-2 w-full">
                                      <ShoppingCart class="scale-200"/>    
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
