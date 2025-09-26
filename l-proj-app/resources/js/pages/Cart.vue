<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { PlusCircleIcon, MinusCircleIcon, DeleteIcon } from 'lucide-vue-next';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Корзина',
        href: dashboard().url,
    },
];

const totalPrice = ref(0);

const cart_items = ref([]);

    const cartData = async () => {
      try {
        const response = await axios.get('/cart-data');
        cart_items.value = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
      calculateTotal();
    };

var calculateTotal = async () => {
  totalPrice.value = 0;
  cart_items.value.forEach(element => {
    totalPrice.value += element.price * element.cart_amount;
  });
  return totalPrice;
}

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

var removeFromCart = async (id) => {
      try {
        const response = await axios.post('/cart-remove', {
          item_id: id,
        });
        console.log(response.data);
      } catch (error) {
        console.error('Error sending data:', error);
      }
    };

var deleteFromCart = async (id) => {
      try {
        const response = await axios.post('/cart-delete', {
          item_id: id,
        });
        console.log(response.data);
      } catch (error) {
        console.error('Error sending data:', error);
      }
    };

var placeOrder = async () => {
      try {
        const response = await axios.post('/order-place', {
          total: totalPrice.value,
        });
        console.log(response.data);
      } catch (error) {
        console.error('Error sending data:', error);
      }
      cartData();
    };

var plusButton = async (id) => {
  addToCart(id);
  cartData();
}

var minusButton = async (id) => {
  removeFromCart(id);
  cartData();
}

var deleteButton = async (id) => {
  deleteFromCart(id);
  cartData();
}

var isButtonDisabled = (inputValue: number) => computed(() => {
      return (inputValue <= 1); 
    });
  
onMounted(() => {
  cartData();
});
</script>

<template>
    <Head title="Магазин" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
          <div v-if="totalPrice === 0" class="text-4xl text-[#706f6c] dark:text-[#A1A09A] place-self-center">
            Ваша корзина пуста
          </div>
          <div v-else class="grid auto-rows-min gap-4 md:grid-cols-1">
                <div v-for="item in cart_items" :key="item.id">
                    <div class="relative min-w-[150vh] overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <!--<img :src="('./assets/items/'+item.name+'.jpg')"><DeleteIcon />-->
                        <div class="grid auto-rows-min gap-4 grid-cols-10 items-center">
                            <img :src="('./assets/items/'+item.name+'.jpg')">
                            <div class="text-[#706f6c] dark:text-[#A1A09A] col-span-4">
                                {{ item.description }}
                            </div>
                            <Button variant="ghost" size = "default" @click="deleteButton(item.id)"
                              class="text-[#706f6c] hover:text-[#ff6f6c] dark:text-[#A1A09A] dark:hover:text-[#11ff6c]">
                                  Удалить
                            </Button>
                            <Button variant="ghost" size = "icon" :disabled="isButtonDisabled(item.cart_amount).value" @click="minusButton(item.id)"
                            class="text-[#706f6c] hover:text-[#ff6f6c] dark:text-[#A1A09A] dark:hover:text-[#11ff6c] scale-200 justify-self-end">
                                  <MinusCircleIcon />
                            </Button>
                            <div class="text-[#706f6c] dark:text-[#A1A09A] place-self-center">
                                {{ item.cart_amount }}
                            </div>
                            <Button variant="ghost" size = "icon" @click="plusButton(item.id)"
                              class="text-[#706f6c] hover:text-[#ff6f6c] dark:text-[#A1A09A] dark:hover:text-[#11ff6c] scale-200">
                                  <PlusCircleIcon />
                            </Button>
                            <div class="text-[#706f6c] dark:text-[#A1A09A]">
                                {{ item.cart_amount * item.price / 100 }},{{ item.cart_amount * item.price % 100 }}р
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid auto-rows-min gap-4 grid-cols-2 items-center">
                  <div class="text-[#706f6c] dark:text-[#A1A09A] text-4xl">
                    Общая сумма: {{ totalPrice / 100 }},{{ totalPrice % 100 }}р
                  </div>
                  <Button variant="ghost" size = "default" @click="placeOrder()"
                    class="text-4xl hover:bg-[#ff6f6c] dark:hover:bg-[#11ff6c] h-full text-[#706f6c] hover:text-[#ffffff] dark:text-[#A1A09A] dark:hover:text-[#ffffff]">
                      Оформить заказ
                  </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
