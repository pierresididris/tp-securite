import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormRegisterComponent } from './form-register/form-register.component';
import { FormConnectionComponent } from './form-connection/form-connection.component';
import { RouterModule, Routes, Router } from '@angular/router';
import { HomeUserComponent } from './home-user/home-user.component';

const routes = [
  { path: 'register', component: FormRegisterComponent },
  { path: 'connection', component: FormConnectionComponent },
  { path: 'home-user', component: HomeUserComponent },
]

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    RouterModule.forRoot(routes),
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
