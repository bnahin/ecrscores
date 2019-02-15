<div class="box filter-box">
    <div class="box-body">
        <h4>Filter Columns</h4>
        <div class="row filter-row">
            <div class="col-xs-4">
                <div class="form-check">
                    @php $id = abs(crc32( uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="math_scale"
                           id="mathscale-{{$id}}" checked>
                    <label class="form-check-label" for="mathscale-{{$id}}">
                        Math Scale
                    </label>
                </div>
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="math_level"
                           id="mathlevel-{{$id}}" checked>
                    <label class="form-check-label" for="mathlevel-{{$id}}">
                        Math Level
                    </label>
                </div>
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="reasoning"
                           id="reasoning-{{$id}}">
                    <label class="form-check-label" for="reasoning-{{$id}}" rel="tooltip"
                           title="Communicating and Reasoning">
                        Reasoning
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           value="concepts"
                           id="concepts-{{$id}}">
                    <label class="form-check-label" for="concepts-{{$id}}">
                        Concepts/Procedures
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="modeling"
                           id="modeling-{{$id}}">
                    <label class="form-check-label" for="modeling-{{$id}}" rel="tooltip" title="Problem Solving and Modeling">
                        Problem Solving
                    </label>
                </div>
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="ela_scale"
                           id="elascale-{{$id}}" checked>
                    <label class="form-check-label" for="elascale-{{$id}}">
                        ELA Scale
                    </label>
                </div>
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="ela_level"
                           id="elalevel-{{$id}}" checked>
                    <label class="form-check-label" for="elalevel-{{$id}}">
                        ELA Level
                    </label>
                </div>
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="inquiry"
                           id="inquiry-{{$id}}">
                    <label class="form-check-label" for="inquiry-{{$id}}">
                        Inquiry
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                @php $id = abs(crc32(uniqid())) @endphp
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           value="listening"
                           id="listening-{{$id}}">
                    <label class="form-check-label" for="listening-{{$id}}">
                        Listening
                    </label>
                </div>
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="reading"
                           id="reading-{{$id}}">
                    <label class="form-check-label" for="reading-{{$id}}">
                        Reading
                    </label>
                </div>
                <div class="form-check">
                    @php $id = abs(crc32(uniqid())) @endphp
                    <input class="form-check-input" type="checkbox"
                           value="writing"
                           id="writing-{{$id}}">
                    <label class="form-check-label" for="writing-{{$id}}">
                        Writing
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>