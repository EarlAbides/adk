<?php
	
	//echo date('G i s');
	//phpinfo();
    //echo sha1(openssl_random_pseudo_bytes(40));

	////batch make thumbs
	//require_once 'File.php';

	//$files = [['6','1','612ed00cdcfc3b4bf89584a793c0c653c8f12e70'],
	//        ['a','e','ae32a45f4a6bd81cfcf6781f1720f9d30967b1d5'],
	//        ['d','0','d00708d2d8e3b13c5aea1bfde36e368bd1e99d11'],
	//        ['a','b','ab8ed4b5093f743f8ff062e7e598de2a23383d34'],
	//        ['1','2','12db62efbca1389ce17cdb376d47bfbe4dec4c5b'],
	//        ['d','6','d6da9fe27289492db47929debb129a94259f01ea'],
	//        ['c','2','c2373c9197a624e526867dea23cc2c16c0eabf01'],
	//        ['c','a','ca19aa59fbca6df07f84a55472c8f271f9207ed2'],
	//        ['3','8','38f9df837ab537536a9b032cf19422e099ab8db7'],
	//        ['8','e','8e0890be8b43cb6e104c4deb8f77b942713acefc'],
	//        ['1','d','1d47c2b361defa309318c5f5f0e6d2008ae04d59'],
	//        ['d','b','db39a781d9d4d0076b73ce4004c4b9c2e553a565'],
	//        ['f','c','fc873f5ded039af74e5dcfcf543c3cffb4bbf8a0'],
	//        ['b','3','b3f002ae9e0a0d655e0b935d216dbaa7847d78ff'],
	//        ['a','a','aa4dad4ca40cad26b9b3ec70519aa6e7bfa9bf17'],
	//        ['6','6','66694cb88636e75bf3d63cce6382ef6b15a6ff45'],
	//        ['d','e','de75cfc1c309c009472fbf8fac0c0a8af9324b7f'],
	//        ['0','d','0dff8e98a0a0a01f9dfc53afce4981e7340a1e2a'],
	//        ['6','6','66c8ef63f62197eea57f692072791485b5fd5c65'],
	//        ['9','b','9bb888d21f4a256384b90f778bf768c5026671cf'],
	//        ['9','1','9154eb5eddbd8d12be0c9e78b97ee9c7dfb96fb7'],
	//        ['f','3','f3ee3994978b81496f5473adcd606a7cfdd0c8dd'],
	//        ['3','7','375361b2bbdd746bb12f7d0851328ce55315e75f'],
	//        ['1','c','1c9a064a92d12023e8431b5f2cd6ee8db5b16e76'],
	//        ['1','7','17581b469ab2a00120e32caf8d66de2de3ed0da2'],
	//        ['0','f','0ff4357a3620d4dec71073e2afe3019b54e550bc'],
	//        ['0','d','0d511e9782621a9fca6ee8e43d3cbde759cb0041'],
	//        ['2','8','28ee34c26dfaa45b76e43a149fbbd8909694e6d4'],
	//        ['3','9','3936c17cd5eab2d8341dcbc5f293dfa183effdae'],
	//        ['c','4','c43da4a7b71b911f1ec22c72acd22af8c2eb937b'],
	//        ['3','4','34ba9028fbe6a121a2d7a6fa93c97974584fbda7'],
	//        ['a','e','ae6812cad46ac7393170a2ea8b348283aaf8b523'],
	//        ['a','6','a6ff79ffe07b22a877db7e253d1a9c00368676e6'],
	//        ['3','0','3032e9a0c94fa002f12c5b63da630a96dc04a5d9'],
	//        ['0','5','05f7979fe803d9861c9b616b545fb0b8acb4f6b5'],
	//        ['c','7','c7bd354b63db38c6d87365eadd9e2286679d98ca'],
	//        ['a','f','aff9a0f5381b70f0e345709071985b56ae24ce07'],
	//        ['6','2','6284246e291a5038737f69afc1e2c4348164b8be'],
	//        ['6','3','63418bcf896fe00cdea559ada8026503c76f8eec'],
	//        ['d','2','d2170822a584d7384319bbb5d50816d0099e85cd'],
	//        ['0','1','019c47d9158ef89cb7afe868444f4803b0052704'],
	//        ['7','0','7090d01fdd35dac1afa555596f54e19ad5a6f4f6'],
	//        ['b','4','b4e643cb70b5d824c9a0bee11c53e10671d56e1d'],
	//        ['1','3','13b74d20b0db16dddf33a1584bf3be936a2d0061'],
	//        ['3','7','37c8044f93c64213b40c87d6442e0ab597d9bdc7'],
	//        ['7','c','7cd4f1f3a14648bd31da6993db8a1da725e33dab'],
	//        ['8','4','849a72454fa0684dd42247b54e00d3467238b3ea'],
	//        ['1','1','110d047b6765fec2b2efc04806ff44506bdf56ab'],
	//        ['e','4','e4ab6782471b64c6e259bba923f2379e6e417b1c'],
	//        ['8','b','8b3cc7fcd30b7f09bc863f2e828b07a201d01535'],
	//        ['2','4','24430fb5675f46ad929b0d8c3fb0b5fca9ea4d08'],
	//        ['0','6','064f6d5eaf8d0dfa63382f2ccee9ace4e2be6650'],
	//        ['0','c','0ca5af99fa2f99af9ca8037b26c18f9f8ea4f187'],
	//        ['7','d','7df2eac43e255d702bbfda6328461ecef7ed8345'],
	//        ['e','1','e1d4a96105309c8c9045bce84004907b77e9f738'],
	//        ['8','e','8e3a2a19b7ed9edb3f48b66a8c97820f2ff470b1'],
	//        ['2','3','2368e8a1943e33639270f4aac2524af9f809a192'],
	//        ['3','0','301539ab0f1836d37c9f0a62c51468507ee86b8e'],
	//        ['f','7','f776fb5eb979fe73697f93297506d7f495aa6990'],
	//        ['d','f','dfa7bf66032673fc4b35c9c36624243dcf477967'],
	//        ['7','0','7027f146a3e6f2c5ea2d8e99bc39f0572cf2439f'],
	//        ['2','f','2fd93ed85ecaed54bdfefb45941ab401860dcd46'],
	//        ['b','d','bd7c4fe0c19d4c2b75f7cb981f00eae11cfce8e0'],
	//        ['c','b','cbac4079abca53994c2bc04025c646d0977a82d2'],
	//        ['5','5','5547bad56cbc0cac5e3abfe45748fd14536e692c'],
	//        ['0','a','0ac8a2f0b5026e6569d30f6ee1d3e543be9ae1fa'],
	//        ['9','d','9d9d948a43804a4fa98bdc29b7e8871ac189be59'],
	//        ['a','5','a574f389d91832babb20ca99c413ef32ebccf787'],
	//        ['7','9','79f7b8b3861b5a38cb10adbf4a98586cc502694d'],
	//        ['e','2','e20ae780e09ce92c8d36bb59547ec5bd691509e2'],
	//        ['3','9','392c1f816663efec1e928f8b89be5e7afbca06d4'],
	//        ['9','b','9b47baa367e85ced534abf0abd9a101d926380eb'],
	//        ['7','7','77f86e4e77cf2dfdc032eab3faa414ec45e85d39'],
	//        ['8','2','82ae413b78a8ee533c7597dc016900c55a3d07fa'],
	//        ['8','9','890cea5bd169c30128684a3787d5ab60c9573c18'],
	//        ['9','4','94b2b67b5d4bf6cf173a24e7a28b3ec232dbd7a6'],
	//        ['6','e','6e47a067c0788cdb5f38cf94273b258f5c56003a'],
	//        ['d','b','db9eaf5c674b885b7b46cb8c5008a8886de9a463'],
	//        ['c','7','c7971c31e92577ecfd85a9d544959cc196a02ef9'],
	//        ['c','6','c6f25720b248a1f92d88181cdca85a6c7152bbd9'],
	//        ['9','6','96e5e805a47155ab2bd9774cd10ddd414a854ac0'],
	//        ['6','4','6473fa7e80a38918ffc1d032362f6ff09dad5f7f'],
	//        ['5','b','5bf9fcc34aad6f41b611687f43bfe7376aa53eba'],
	//        ['9','f','9f90f6e8cec4362128937441448ef893f73c3ae4'],
	//        ['5','5','553b68006d27f3bc79b774f6d8bba94ddf945dbe'],
	//        ['e','1','e1a3ff52f916ecb042bebea9cf148830e0e0fd25'],
	//        ['f','a','fab07bd1a445508954e249113cc0c6ead67f9776'],
	//        ['5','c','5c9556c94cdc2d9ce68e62a83a8b59522f00d5f2'],
	//        ['e','2','e2ce10e29191c46f04b68a62c86aaa361d86c38e'],
	//        ['0','b','0b266cdaf7a73fd4638b1716457c4f9c91b889d5'],
	//        ['2','1','2199a7187374e0ad05d1cee67b4643d2356cba15'],
	//        ['f','e','fe3816bdb92cb1a8b3836855e5f4a7d7f121af2e'],
	//        ['7','e','7e463fe0bfc453311207aa93c16d0ea733cbd406'],
	//        ['9','8','98e39a125b08e3fcb832dad1154d771104e68bf1'],
	//        ['6','e','6e9316bd42154bd793f1cbc840917e4d0fbceaa0'],
	//        ['8','4','841c1c7e56d0776a4235448b141815f6b5f71d18'],
	//        ['a','5','a5641611ea1a1103a2c4b840be074d44d02f6e1a'],
	//        ['d','e','deb8a253c130a14932aba8c2606eb977a935c76e'],
	//        ['7','d','7de1ecdcb346a5b720e1f7b7a5bd1e2e34ddfc8d'],
	//        ['e','8','e83265879584ce0c16670d5f5640b88fa3e6e32c'],
	//        ['9','7','972e2e569316f3f038fe3fac453872019e7d363b'],
	//        ['e','d','ed7b4970e33f8de599ed941ac6598aee1f1b8b8f'],
	//        ['9','b','9bae4d5aafeb5b8b62b1ce50f66c4f42006b2496'],
	//        ['a','f','af02ebddd72d90428a6090b4da2e13c33e6a1e3b'],
	//        ['1','f','1fd9d6e483543a13a13492412530f8c0c7ac3e51'],
	//        ['9','8','98fb5c21ac8408425460ad118bec6e9665e18c72'],
	//        ['b','e','be736cd7fb060b964c9bc060da8b2d9ab1d103db'],
	//        ['c','2','c241b1673e24cb0879b5b97cda4e1c4ee1e62022'],
	//        ['1','9','196e7a985c3fe1c6f14450e3306458c312b76ae6'],
	//        ['3','7','37d89c74dee939bc3bde30c8468b62e3216b0883'],
	//        ['7','4','74980e03202fd7a756900e09d9c4d42f8e8cadf0'],
	//        ['2','6','269916e632016bde59d0ab442cd4d6c82557e260'],
	//        ['0','c','0cc4c9f8103145212bc92cf31ac301abf2ce19a2'],
	//        ['f','e','fe64b96b0d4f8a37ae3ebd726c45c5d64cc26f68'],
	//        ['0','b','0b3fdb4aa323507b6a0059b2b2d3b6b7ccc76188'],
	//        ['8','8','889e3ed454a367289aae62389120deac0b9a46e0'],
	//        ['3','a','3a4ea89709197f7a2c6077e24a2544e04f734ef9'],
	//        ['2','3','23132d9acd6851e85c791be1cfa6c03a076105f1'],
	//        ['0','2','02321dea6cc763c5acae78dbb2e71424e3ba593f'],
	//        ['c','0','c0f625b7cf87a5e1ae4640ca0b1fc797f2de4510'],
	//        ['6','7','6740538e0154971a8bc58da68ba7b7be0f18f61a'],
	//        ['5','5','55499660864cc9302089f56b5e355e21cffde18d'],
	//        ['3','1','312163fb90414b9c330c15a088d5427012f48c40'],
	//        ['c','9','c9c693367e49724398c1b85448dff704d9c70682'],
	//        ['1','6','16af3222a43dcd44c2d6ddb188ed61b13ab6979e'],
	//        ['9','9','99e0bb2231150fd394d59bbbb8a68fc7cdcf43be'],
	//        ['4','b','4becb25f798c82feca48e6ce73811d9b26e3ac0e'],
	//        ['2','c','2c185ed1731c906f1fb74f79791c814c3ee196e6'],
	//        ['a','d','adc79c03c456789e20f4bcba4d6b082b31b40ed9'],
	//        ['8','4','8428620e891c0ec0018ceaab57712dc7163c7dd2'],
	//        ['1','a','1a11f5f5935976224a9b67c2352f0deaf8a690db'],
	//        ['2','3','233ee7bb49d487f35014ef2e2e1ca7dd405aa073'],
	//        ['7','0','707a781ea8769d2e167c6b65ed5f1d8bc44ddc50'],
	//        ['e','a','eac2f464c3f35d95589a23b0dfaa4687b7c9d5d5'],
	//        ['1','4','14d64f6668541dc9ae551d725ee9984607e3ade3'],
	//        ['1','7','178b183e6b7b713f4a0c5aebc32819ef61366b29'],
	//        ['5','b','5b839a16b77846d3961a0066723870b6f774906c'],
	//        ['1','6','164d72dd99c400e2972e40ce443d90ea195e56b3'],
	//        ['5','d','5de7850565435ea718c471efd99e8b8852a0319b'],
	//        ['9','f','9f673b48d1c4bb40b025adb2dc67d734daa65ce2'],
	//        ['7','f','7fbfe1760f72fe62b20c1f7d0e1e339ecc3514f2'],
	//        ['c','d','cd637522ad983a3860f1476e4e666c128090ddf0'],
	//        ['9','b','9b0536bab81dd7534f9066d32e8529a8b57072fd'],
	//        ['e','e','ee9fc133a5f6d59928a9f35c26220eba1f1546de'],
	//        ['9','2','9234e70bbf7eb7214499325427fed787cce79fce'],
	//        ['a','b','ab296d2ee50f37051a35dfbb86cf71f927d4136d'],
	//        ['5','2','5271e73de5bfb2754222c82bf4e48268639ab5f4'],
	//        ['c','6','c60934da29111cbd3adc861336ff4e26ed5f39c0'],
	//        ['9','9','99dc44a55cfe77670aed2b69cdc5c166ab944db2'],
	//        ['7','3','7381d9a3363abd659c3e2c58137652142e8c1e62'],
	//        ['c','6','c6e1b28680d13ba1c8bb1f0be75df50b2ee88140'],
	//        ['9','a','9a2b5cd579544d807a4476bccb24625e634ed1c1'],
	//        ['b','d','bdac3306fffe93eed96fc3fdbd04971d8314a947'],
	//        ['4','8','4899763abddba101904406f66e65861efb060f3f'],
	//        ['3','5','3547847694f2081a9327009df981dd3e31a764d8'],
	//        ['c','f','cf28dd6d78e551806a944dd0dd9689e6fe9e8cd1'],
	//        ['9','a','9acb909bd3228d11569965f821f0c05c968a3a2a'],
	//        ['1','b','1b1403eeba099e04fe4e71575eb84927dd790294'],
	//        ['f','e','fe57e55d59380c080d9ab6756f9cb477c9e1902a'],
	//        ['8','c','8c72fd75b322be36c196f7a5ecb269bfde81a741'],
	//        ['1','e','1ea014d7cc4c71ecec64de74ba100d63e7ce01a0'],
	//        ['b','c','bc9280af12321bf3797344fc9e0f808c8673d118'],
	//        ['0','b','0b34e732d0c119ccfaec03da6558d9661eb3861c'],
	//        ['6','e','6e2e329ad8db92aaee1c1cac62131bb9a5b10c76'],
	//        ['b','2','b2c4cf4d0f6885fd134d534fcba2be8a00a55f70'],
	//        ['6','4','642d9836496dac2228d17ba877708a53a01ee151'],
	//        ['a','8','a88fcbebeb1cf62a06c28faa17f083103bfec5e9'],
	//        ['d','e','de764991dab640ed5aae2fef82d37099aafc5cf4'],
	//        ['7','d','7d67c9e0d3b713eca3b3f97af60ab3e5b0a98a6e'],
	//        ['2','6','267173f36068ee77ae1e7efd533a1083d203b706'],
	//        ['1','7','17f261757b25174185a7e4755becf78be709d455'],
	//        ['4','0','40bde74071b4784804f89fd7fa286b129bf98d39']];

	//for($i = 0; $i < count($files); $i++){
	//    $src = '../uploads/'.$files[$i][0].'/'.$files[$i][1].'/'.$files[$i][2];
	//    $dest = '../uploads/thumb/'.$files[$i][0].'/'.$files[$i][1];
	//    if(!is_dir($dest)) mkdir($dest, 0777, true);
	//    $dest .= '/'.$files[$i][2];
	//    if(!file_exists($dest)) makeThumbnail($src, $dest, 160);
	//}

?>