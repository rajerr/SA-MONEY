import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.scss'],
})
export class AdminComponent implements OnInit {
  public appPages = [
    { title: 'Inbox', url: '/admin/Inbox', icon: 'mail' },
    { title: 'Outbox', url: '/admin/Outbox', icon: 'paper-plane' },
    { title: 'Favorites', url: '/admin/Favorites', icon: 'heart' },
    { title: 'Archived', url: '/admin/Archived', icon: 'archive' },
    { title: 'Trash', url: '/admin/Trash', icon: 'trash' },
    { title: 'Spam', url: '/admin/Spam', icon: 'warning' },
  ];
  public labels = ['Family', 'Friends', 'Notes', 'Work', 'Travel', 'Reminders'];

  constructor() { }

  ngOnInit() {}

}
