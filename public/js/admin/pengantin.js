$(document).ready(function() {

    function load_table()
    {
        let link_api = $("meta[name='link-api']").attr("link");
        $("table#data_pengantin").DataTable().destroy();
        $("table#data_pengantin").DataTable({
            ajax: {
                url: link_api,
                headers: {
                    Authorization: "Bearer " + get_cookie("ALD_SESSION"),
                },
                type: "POST",
            },
            serverSide: true,
            processing: true,
            aaSorting: [[0, "desc"]],
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return (
                            meta.row + meta.settings._iDisplayStart + 1 + "."
                        );
                    },
                },
                {
                    data: null,
                    render: (res) => {
                        return `<a href="">${res.name_invitation}</a>`
                    }
                },
                { data: "name", name: "name" },
                {
                    data: null,
                    render: (res) => {
                        return `<span>${res.name_groom} & ${res.name_bride}</span>`
                    }
                },
                {
                    data: null,
                    render: (res) => {
                        const wedding_date = new Date(res.wedding_date);
                        let d = String(wedding_date.getDate()).padStart(2, '0');
                        let m = String(wedding_date.getMonth()+1).padStart(2,"0");
                        let y = wedding_date.getFullYear();
                        return `${d}-${m}-${y}`;
                    }
                },
                {
                    data: null,
                    render: (res) => {
                        return `
                        <a href="#" class="btn btn-primary btn-sm btn-edit" data-id="${res.id}" data-name="${res.name}" data-logo="${res.logo}" style="color: #FFF;" title="edit"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm btn-hapus" data-id="${res.id}" data-name="${res.name}" style="color: #FFF;" title="hapus"><i class="fa fa-trash"></i></button>
                        `;
                    },
                },
            ],
        });
    }
    load_table();

})
