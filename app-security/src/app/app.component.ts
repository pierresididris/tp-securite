import { Component } from '@angular/core';
import { UserService } from './user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app-security';

  constructor(
    public userService: UserService,
    private router: Router,
  ){

  }

  ngOnInit(){

  }

  disconnectUser(): void {
    console.log("disconnectUser");
    this.userService.deconnectUSer().subscribe((response) => {
      if(response.sessionDestroy){
        this.router.navigate(['/connection']);
      }
    });
  }
}
