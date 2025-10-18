<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Card } from "primevue";
defineProps({});
</script>

<template>
    <AdminLayout title="Welcome To Nuxus">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-1">
                ยินดีต้อนรับ
                {{ $page.props.auth.user.name }}
            </h1>
            <p class="text-sm opacity-75">
                ภาพรวมข้อมูลและสถิติของระบบ Smart Travel Search
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- จังหวัดทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                จังหวัดทั้งหมด
                            </p>
                            <p class="text-4xl font-bold text-blue-600 mb-2">
                               
                            </p>
                            <p class="text-xs opacity-60">
                                <i
                                    class="pi pi-arrow-up text-green-500 mr-1"
                                ></i>
                                ครบทั้ง 77 จังหวัด
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-map text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- สถานที่ท่องเที่ยวทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-green-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                สถานที่ท่องเที่ยว
                            </p>
                            <p class="text-4xl font-bold text-green-600 mb-2">
                                
                            </p>
                            <p class="text-xs opacity-60">
                                <i
                                    class="pi pi-arrow-up text-green-500 mr-1"
                                ></i>
                                เพิ่มขึ้น 12% จากเดือนที่แล้ว
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-map-marker text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- ผู้ใช้งานทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-purple-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                ผู้ใช้งาน
                            </p>
                            <p class="text-4xl font-bold text-purple-600 mb-2">
                                
                            </p>
                            <p class="text-xs opacity-60">
                                <i
                                    class="pi pi-arrow-up text-green-500 mr-1"
                                ></i>
                                ผู้ใช้งานใหม่ 45 คน
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-purple-400 to-purple-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-users text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- รีวิวทั้งหมด -->
            <Card
                class="shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-orange-500"
            >
                <template #content>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-75 mb-2">
                                รีวิวทั้งหมด
                            </p>
                            <p class="text-4xl font-bold text-orange-600 mb-2">
                                
                            </p>
                            <p class="text-xs opacity-60">
                                <i
                                    class="pi pi-star-fill text-yellow-500 mr-1"
                                ></i>
                                คะแนนเฉลี่ย 4.5/5.0
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-orange-400 to-orange-600 p-4 rounded-2xl shadow-lg"
                        >
                            <i class="pi pi-star text-white text-4xl"></i>
                        </div>
                    </div>
                </template>
            </Card>
        </div>
    </AdminLayout>
</template>
