<script setup>
import { ref, onMounted, reactive } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import Loading from "./Loading.vue";

const isLoading = ref(false);

</script>

<template>
    <div class="mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info bg-gradient">
                        รายชื่อผู้ใช้งานระบบ
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fas fa-users"></i> Add User
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">รหัสพนักงาน</th>
                                        <th scope="col">ตำแหน่ง</th>
                                        <th scope="col">ชื่อ-นามสกุล</th>
                                        <th scope="col">สิทธิใช้งาน</th>
                                        <th scope="col">สถานะ</th>
                                        <th scope="col">แก้ไข</th>
                                    </tr>
                                </thead>
                                <tbody v-if="isLoading">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <loading></loading>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-if="items.length === 0">
                                        <td colspan="7" class="text-center">
                                            ไม่พบข้อมูล
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(item, index) in items" :key="index" class="text-center">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.user_ref.code }}</td>
                                        <td>
                                            {{
                                                item.user_ref.position_ref.name
                                            }}
                                        </td>
                                        <td>{{ item.user_ref.name_eng }}</td>
                                        <td>{{ item.role_type }}</td>
                                        <td>
                                            {{
                                                item.active == "1"
                                                    ? "active"
                                                    : "Disable"
                                            }}
                                        </td>
                                        <td>
                                            <button v-if="
                                                item.user_id !==
                                                roleUser.user_id
                                            " @click="editItem(item)" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button v-if="
                                                item.user_id !==
                                                roleUser.user_id
                                            " @click="deleteItem(item)" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <select class="form-select" id="role_type" name="role_type">
                            <option value="">เลือก สิทธิใช้งาน</option>
                            <option value="SuperAdmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="code" name="code" placeholder="รหัสพนักงาน" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button v-if="!isLoadingAddData" type="button" class="btn btn-primary" @click="addData">
                        Save
                    </button>
                    <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <select class="form-select" id="role_typee" name="role_typee" v-model="editUser.role_type">
                            <option value="">เลือก สิทธิใช้งาน</option>
                            <option value="SuperAdmin">SuperAdmin</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" id="codee" name="codee" placeholder="รหัสพนักงาน"
                            v-model="editUser.code" />
                        <select class="form-select" id="active" name="active" v-model="editUser.active">
                            <option value="1">Active</option>
                            <option value="0">Disable</option>

                        </select>

                        <input type="hidden" class="form-control" id="id" name="id" v-model="editUser.id" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button v-if="!isLoadingAddData" type="button" class="btn btn-primary" @click="updateData">
                        Update
                    </button>
                    <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
