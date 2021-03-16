import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-vue',
  templateUrl: './vue.component.html',
  styleUrls: ['./vue.component.scss'],
})
export class VueComponent implements OnInit {

  constructor(private router: Router) {
    setTimeout(() => {this.router.navigateByUrl("login")}, 5000)
   }
   

  ngOnInit() {}

}
