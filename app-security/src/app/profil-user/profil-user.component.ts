import { Component, OnInit } from '@angular/core';
import { User } from '../user';
import { UserService } from '../user.service';

@Component({
  selector: 'app-profil-user',
  templateUrl: './profil-user.component.html',
  styleUrls: ['./profil-user.component.css']
})
export class ProfilUserComponent implements OnInit {
  editMail: boolean;

  constructor(public userService: UserService) { }

  ngOnInit() {
    this.editMail = false;
    this.userService.setConnectedUser().then((response) => {
      if(this.userService.connectedUser.profilId == 1){
        this.userService.connectedUser.profilLabel = 'employé'
      }
      if(this.userService.connectedUser.profilId == 2){
        this.userService.connectedUser.profilLabel = 'employeur';
      }
    });
  }

}
