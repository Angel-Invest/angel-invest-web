<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit startup') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('startups.update', $startup)}}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome', $startup->nome)}}">
                </div>
                <div class="form-group">
                    <label for="cnpj">cnpj</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{old('cnpj', $startup->cnpj)}}">
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{old('email', $startup->email)}}">
                </div>
                <div class="form-group">
                    <label for="descricao">descricao</label>
                    <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="3">{{old('descricao', $startup->descricao)}}</textarea>
                </div>
                <div class="form-group">
                    <label for="logo">logo</label>
                    <input type="file" name="logo" class="form-control-file" id="logo">
                </div>
                <div class="form-group">
                    <label for="area">area</label>
                    <select id="area"
                        name="area"
                        class="form-control">
                        @foreach ($areas as $id => $area)
                            <option value="{{ $id }}"
                                {{ old('area', $startup->area->id) == $id ? 'selected' : '' }}>
                                {{ $area }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Confirm</button>
            </form>
        </div>
    </div>
    <script>
        CKEDITOR.replace( 'descricao' );
        $("#cnpj").mask("99.999.999/9999-99");
    </script>
</x-app-layout>