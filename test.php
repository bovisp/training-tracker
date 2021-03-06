<?php

        @if(moodleauth()->user()->can('edit posts'))
            Yes I can
        @endif

        <form action="/test" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            
            <div class="field">
                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="myfile">

                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fa fa-upload"></i>
                            </span>

                            <span class="file-label">
                                Choose a file…
                            </span>
                        </span>

                        <span class="file-name">
                            
                        </span>
                    </label>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-info" type="submit">Submit</button>
                </div>
            </div>
        </form>


        @if (session()->has('error'))

            <table class="table">
                <thead>
                    <tr>

                        @foreach (session()->get('headers') as $header)
                            
                            <th>

                                {{ $header }}

                            </th>

                        @endforeach

                    </tr>
                </thead>

                <tbody>
                    
                    @foreach (session()->get('error') as $row)

                        <tr>

                            @foreach($row["data"] as $data)

                                <td>{{ $data }}</td>
                                

                            @endforeach


                            
                        </tr>
                        <tr>
                            <td colspan="{{ count($row['data']) }}">
                                <article class="message is-danger">
                                    <div class="message-body">
                                        <ul>
                                            @foreach($row["errors"] as $error)
                                                <li>&bull; {{ $error[0] }}</li>
                                            @endforeach
                                        </ul>
                                    </div
                                </article>
                            </td>
                        </tr>
                        

                    @endforeach

                </tbody>
            </table>

        @endif