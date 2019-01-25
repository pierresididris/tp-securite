import { Component, OnInit, Input } from '@angular/core';
import { User } from '../user';
import { UserService } from '../user.service';
import { RouterModule, Routes, Router } from '@angular/router';

@Component({
  selector: 'app-form-register',
  templateUrl: './form-register.component.html',
  styleUrls: ['./form-register.component.css']
})
export class FormRegisterComponent implements OnInit {
  user: User;
  password: string;
  passwordConfirm: string;
  userAlreadyExist: boolean;
  passwordNotEquals: boolean;

  constructor(
    public userService: UserService,
    private router: Router,
  ) { 
    
  }

  ngOnInit() {
    this.user = new User();
    this.userAlreadyExist = false;
    this.passwordNotEquals = false;
  }

  add(): void{
    console.log("========================")
    this.userAlreadyExist = false;
    this.passwordNotEquals = false;

    if(this.userService.checkPwd(this.password, this.passwordConfirm)){
      this.user.password = this.password;
      if(this.userService.checkMail(this.user.email) && this.userService.checkProfil(this.user.profilId)){
        this.userService.addUser(this.user).subscribe((response) => {
          console.log("after mapped", response)
          if(response.memberAlreadyExists){
            this.userAlreadyExist = true;
          }
          if(response.result){
            this.router.navigate(['/connection'])
          }
        });
      }
    }else{
      this.passwordNotEquals = true;
    }
  }

}
